<?php

namespace Tests\Feature;

use Tests\TestCase;

final class ComponentTest extends TestCase
{
    public function test_button_component_renders_correctly(): void
    {
        $rendered = blade()->component('button', [
            'variant' => 'primary',
            'size' => 'md',
            'slot' => 'Save Changes',
        ]);

        $this->assertStringContainsString('btn btn-primary btn-md', $rendered);
        $this->assertStringContainsString('Save Changes', $rendered);
    }

    public function test_badge_component_renders_and_escapes_xss(): void
    {
        $rendered = blade()->component('badge', [
            'variant' => 'success',
            'size' => 'sm',
            'slot' => 'Active User',
        ]);

        $this->assertStringContainsString('badge-success', $rendered);
        $this->assertStringContainsString('badge-sm', $rendered);
        $this->assertStringContainsString('Active User', $rendered);

        $xssRendered = blade()->component('badge', [
            'variant' => 'neutral',
            'slot' => '<script>alert("xss")</script>',
        ]);
        $this->assertStringContainsString('&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;', $xssRendered);
        $this->assertStringNotContainsString('<script>alert("xss")</script>', $xssRendered);
    }

    public function test_alert_component_renders_with_message(): void
    {
        $rendered = blade()->component('alert', [
            'type' => 'warning',
            'title' => 'Caution',
            'slot' => 'Operation is dangerous.',
        ]);

        $this->assertStringContainsString('alert-warning', $rendered);
        $this->assertStringContainsString('Caution', $rendered);
        $this->assertStringContainsString('Operation is dangerous.', $rendered);
    }

    public function test_input_component_renders_form_control_with_label(): void
    {
        $rendered = blade()->component('input', [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Email Address',
            'placeholder' => 'you@domain.com',
            'required' => true,
        ]);

        $this->assertStringContainsString('Email Address', $rendered);
        $this->assertStringContainsString('name="email"', $rendered);
        $this->assertStringContainsString('placeholder="you@domain.com"', $rendered);
        $this->assertStringContainsString('required', $rendered);
    }

    public function test_toggle_component_renders_checkbox_toggle(): void
    {
        $rendered = blade()->component('toggle', [
            'name' => 'dark_mode',
            'label' => 'Dark Theme',
            'checked' => true,
        ]);

        $this->assertStringContainsString('type="checkbox"', $rendered);
        $this->assertStringContainsString('toggle toggle-primary', $rendered);
        $this->assertStringContainsString('Dark Theme', $rendered);
    }

    public function test_icon_component_renders_valid_svg(): void
    {
        $rendered = blade()->component('icon', [
            'name' => 'dashboard',
            'size' => 'sm',
        ]);

        $this->assertStringContainsString('<svg', $rendered);
        $this->assertStringContainsString('w-4 h-4', $rendered);
    }

    public function test_breadcrumb_component_renders_navigation_items(): void
    {
        $rendered = blade()->component('breadcrumb', [
            'items' => [
                ['label' => 'Dashboard', 'url' => '/dashboard'],
                ['label' => 'Settings'],
            ],
        ]);

        $this->assertStringContainsString('breadcrumbs', $rendered);
        $this->assertStringContainsString('href="/dashboard"', $rendered);
        $this->assertStringContainsString('Dashboard', $rendered);
        $this->assertStringContainsString('Settings', $rendered);
    }
}
