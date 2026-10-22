<?php

namespace Tests\Feature;

use App\Models\User;
use DOMDocument;
use Tests\TestCase;

final class FireLineTest extends TestCase
{
    private const HEADERS = [
        'X-FireLine' => '1',
        'X-Requested-With' => 'XMLHttpRequest',
        'Accept' => 'application/json',
    ];

    public function test_guest_pages_return_one_fragment_and_a_title(): void
    {
        foreach (['/', '/login', '/register', '/forgot-password', '/reset-password/token'] as $url) {
            $response = $this->get($url, self::HEADERS)->assertOk();
            $html = $response->json('html');

            $this->assertStringNotContainsString('<!DOCTYPE', $html);
            $this->assertStringNotContainsString('<html', $html);
            $this->assertStringNotContainsString('<script', $html);
            $this->assertNotEmpty($response->json('title'));

            $document = new DOMDocument();
            @$document->loadHTML($html);
            $body = $document->getElementsByTagName('body')->item(0);
            $roots = 0;

            foreach ($body->childNodes as $node) {
                if ($node->nodeType === XML_ELEMENT_NODE) {
                    $roots++;
                    $this->assertSame('div', $node->nodeName);
                }
            }

            $this->assertSame(1, $roots);
        }
    }

    public function test_validation_uses_field_arrays_instead_of_a_redirect(): void
    {
        $this->post('/register', [], self::HEADERS)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'username', 'email', 'password']);
    }

    public function test_wrong_credentials_return_inline_validation(): void
    {
        $this->post('/login', [
            'email' => 'missing@example.com',
            'password' => 'incorrect',
        ], self::HEADERS)
            ->assertUnprocessable()
            ->assertJsonPath('errors.email.0', 'These credentials do not match our records.');
    }

    public function test_registration_navigates_to_the_authenticated_workspace(): void
    {
        $this->post('/register', [
            'name' => 'Nova Builder',
            'username' => 'nova-builder',
            'email' => 'builder@example.com',
            'password' => 'a-long-password',
            'password_confirmation' => 'a-long-password',
        ], self::HEADERS)
            ->assertOk()
            ->assertJsonPath('navigate', (string) route('dashboard'));

        $this->assertAuthenticated();

        $this->get('/dashboard', self::HEADERS)
            ->assertOk()
            ->assertJsonStructure(['html', 'title']);
    }

    public function test_expired_authentication_navigates_to_login(): void
    {
        $this->get('/dashboard', self::HEADERS)
            ->assertOk()
            ->assertJsonPath('navigate', (string) route('login'));
    }

    public function test_authenticated_guests_navigate_back_to_the_workspace(): void
    {
        $user = User::create([
            'name' => 'Nova Builder',
            'username' => 'nova-builder',
            'email' => 'builder@example.com',
            'password' => 'a-long-password',
        ]);

        $this->actingAs($user)->get('/login', self::HEADERS)
            ->assertOk()
            ->assertJsonPath('navigate', (string) route('dashboard'));
    }

    public function test_fireline_does_not_bypass_csrf(): void
    {
        $this->post('/login', [], [...self::HEADERS, 'X-Enable-Csrf' => '1'])
            ->assertStatus(419);
    }
    public function test_authenticated_fragments_with_flash_have_one_root(): void
    {
        $user = User::create([
            'name' => 'Nova Builder',
            'username' => 'nova-builder',
            'email' => 'builder@example.com',
            'password' => 'a-long-password',
        ]);

        $this->actingAs($user);
        session()->flash('status', 'Welcome back.');
        $response = $this->get('/dashboard', self::HEADERS)->assertOk();
        $html = $response->json('html');

        $document = new DOMDocument();
        @$document->loadHTML($html);
        $body = $document->getElementsByTagName('body')->item(0);
        $roots = 0;

        foreach ($body->childNodes as $node) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                $roots++;
            } elseif ($node->nodeType === XML_TEXT_NODE) {
                $this->assertSame('', trim($node->textContent));
            }
        }

        $this->assertSame(1, $roots);
    }

}
