<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $this->get('/')->assertRedirect('/login');
        $this->withoutVite()->get('/login')->assertOk()->assertViewIs('welcome');
    }

    public function test_guests_cannot_read_plans(): void
    {
        $this->getJson('/app/get_plan')->assertUnauthorized();
    }

    public function test_login_requires_valid_input(): void
    {
        $this->postJson('/app/admin_login', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_login_verifies_password_and_starts_a_session(): void
    {
        $user = new User([
            'fullName' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('local-test-password'),
        ]);
        $user->id = 1;
        $role = new Role;
        $role->roleName = 'AdminSup';
        $role->permission = json_encode([['name' => 'releves', 'read' => true]]);
        $user->setRelation('role', $role);

        // Substitute only database retrieval; use Laravel's password and session handling.
        $provider = Mockery::mock(EloquentUserProvider::class, [app('hash'), User::class])
            ->makePartial();
        $provider->shouldReceive('retrieveByCredentials')->twice()->andReturn($user);
        Auth::guard()->setProvider($provider);

        $this->postJson('/app/admin_login', [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ])->assertUnauthorized();
        $this->assertGuest();

        $this->postJson('/app/admin_login', [
            'email' => $user->email,
            'password' => 'local-test-password',
        ])->assertOk()->assertJsonPath('user', 'AdminSup');
        $this->assertAuthenticatedAs($user);
        $this->withoutVite()->get('/releves')->assertOk();
        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
    }
}
