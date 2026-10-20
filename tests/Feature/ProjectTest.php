<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

final class ProjectTest extends TestCase
{
    private function builder(string $username = 'builder'): User
    {
        return User::create([
            'name' => 'Nova Builder',
            'username' => $username,
            'email' => $username . '@example.com',
            'password' => 'a-long-password',
        ]);
    }

    public function test_projects_use_the_authenticated_owner(): void
    {
        $user = $this->builder();

        $this->actingAs($user)->post('/projects', [
            'name' => 'First idea',
            'status' => 'planning',
            'user_id' => 999,
        ], ['X-FireLine' => '1', 'Accept' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest'])
            ->assertOk()
            ->assertJsonPath('navigate', (string) route('dashboard'));

        $this->get('/dashboard')->assertSee('Project created. Make something great.');
        $this->get('/dashboard')->assertDontSee('Project created. Make something great.');

        $this->assertDatabaseHas('projects', [
            'name' => 'First idea',
            'user_id' => $user->id,
        ]);
    }

    public function test_invalid_projects_are_not_created(): void
    {
        $this->actingAs($this->builder())->post('/projects', [
            'status' => 'not-a-status',
        ], ['X-FireLine' => '1', 'Accept' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest'])
            ->assertJsonValidationErrors(['name', 'status']);

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_workspace_hides_other_owners_and_escapes_project_names(): void
    {
        $owner = $this->builder();
        $other = $this->builder('other');

        Project::create(['user_id' => $owner->id, 'name' => '<img src=x onerror=alert(1)>', 'status' => 'planning']);
        Project::create(['user_id' => $other->id, 'name' => 'Private project', 'status' => 'planning']);

        $this->actingAs($owner)->get('/dashboard')
            ->assertOk()
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;')
            ->assertDontSee('<img src=x onerror=alert(1)>')
            ->assertDontSee('Private project');
    }

    public function test_project_search_and_pagination_keep_results_bounded(): void
    {
        $owner = $this->builder();

        for ($index = 1; $index <= 10; $index++) {
            Project::create(['user_id' => $owner->id, 'name' => 'Idea ' . $index, 'status' => 'planning']);
        }

        $response = $this->actingAs($owner)->get('/dashboard');
        $response->assertOk()->assertSee('Next');
        $this->assertSame(8, substr_count($response->content(), '<tr key="project-'));

        $this->get('/dashboard?q=Idea+10')
            ->assertOk()
            ->assertSee('Idea 10')
            ->assertDontSee('edit-project-1-name');
    }

    public function test_owners_can_edit_and_delete_their_projects(): void
    {
        $owner = $this->builder();
        $project = Project::create(['user_id' => $owner->id, 'name' => 'An idea', 'status' => 'planning']);

        $this->actingAs($owner)->patch('/projects/' . $project->id, [
            'name' => 'A finished idea',
            'status' => 'completed',
            'user_id' => 999,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'user_id' => $owner->id, 'status' => 'completed']);

        $this->delete('/projects/' . $project->id)->assertRedirect(route('dashboard'));
        $this->assertDatabaseCount('projects', 0);
    }

    public function test_other_users_cannot_edit_or_delete_a_project(): void
    {
        $owner = $this->builder();
        $project = Project::create(['user_id' => $owner->id, 'name' => 'Private project', 'status' => 'planning']);

        $this->actingAs($this->builder('other'))->patch('/projects/' . $project->id, [
            'name' => 'Changed',
            'status' => 'completed',
        ])->assertNotFound();

        $this->delete('/projects/' . $project->id)->assertNotFound();
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'Private project']);
    }
}
