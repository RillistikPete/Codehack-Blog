<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_the_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
    }

    public function test_authenticated_non_admins_are_forbidden(): void
    {
        $user = User::factory()->create([
            'role_id'   => Role::factory()->create(['name' => 'subscriber'])->id,
            'is_active' => 1,
        ]);

        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    }

    public function test_an_inactive_admin_is_forbidden(): void
    {
        $user = User::factory()->create([
            'role_id'   => Role::factory()->administrator()->create()->id,
            'is_active' => 0,
        ]);

        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    }

    public function test_an_active_admin_can_reach_the_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/admin/dashboard')->assertOk();
    }

    /**
     * Every admin route should be closed to non-admins, not just the dashboard.
     */
    public function test_admin_routes_are_closed_to_non_admins(): void
    {
        $user = User::factory()->create([
            'role_id'   => Role::factory()->create(['name' => 'subscriber'])->id,
            'is_active' => 1,
        ]);

        $this->actingAs($user);

        foreach ([
            '/admin/posts',
            '/admin/posts/create',
            '/admin/users',
            '/admin/categories',
            '/admin/comments',
            '/admin/replies',
            '/admin/media',
        ] as $url) {
            $this->get($url)->assertForbidden();
        }
    }
}