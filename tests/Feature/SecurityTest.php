<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    private function userWith(array $permissions): User
    {
        $user = new User(['fullName' => '</script><script>alert(1)</script>', 'userType' => 'AdminSup']);
        $user->id = 999;
        $role = new Role(['roleName' => 'AdminSup', 'permission' => json_encode($permissions)]);
        return $user->setRelation('role', $role);
    }

    public function test_role_name_alone_does_not_grant_api_access(): void
    {
        $this->actingAs($this->userWith([]));
        foreach (['create_user', 'edit_user', 'delete_user', 'create_role', 'edit_role', 'delete_role', 'assign_role', 'create_plan', 'edit_plan', 'delete_plan', 'create_releveur', 'edit_releveur', 'delete_releveur', 'upload', 'delete_image'] as $action) {
            $this->postJson('/app/'.$action)->assertForbidden();
        }
        foreach (['get_users', 'get_roles', 'get_plan', 'get_releveur', 'get_historique', 'stats', 'releveur_options'] as $action) {
            $this->getJson('/app/'.$action)->assertForbidden();
        }
        $this->deleteJson('/app/clear_historique')->assertForbidden();
    }

    public function test_read_permission_cannot_write_or_fetch_user_records(): void
    {
        $this->actingAs($this->userWith([['name' => 'releves', 'read' => true]]));
        $this->postJson('/app/create_plan')->assertForbidden();
        $this->getJson('/app/get_users')->assertForbidden();
        $this->withoutVite()->get('/releves')->assertOk()->assertDontSee('</script><script>alert(1)</script>', false);
    }

    public function test_portraits_require_authentication_and_read_permission(): void
    {
        $this->get('/uploads/demo-avatar.svg')->assertUnauthorized();
        $this->actingAs($this->userWith([]))->get('/uploads/demo-avatar.svg')->assertForbidden();
        $this->actingAs($this->userWith([['name' => 'releveurs', 'read' => true]]))
            ->get('/uploads/demo-avatar.svg')->assertOk();
    }

    public function test_file_deletion_rejects_path_traversal(): void
    {
        $this->actingAs($this->userWith([['name' => 'releveurs', 'update' => true]]));
        $this->postJson('/app/delete_image', ['imageName' => '../../.env'])->assertUnprocessable();
    }

    public function test_upload_rejects_executable_files(): void
    {
        $this->actingAs($this->userWith([['name' => 'releveurs', 'write' => true]]));
        $this->postJson('/app/upload', ['file' => UploadedFile::fake()->create('shell.php', 1, 'application/x-php')])
            ->assertUnprocessable();
    }

    public function test_page_size_is_bounded_before_querying(): void
    {
        $this->actingAs($this->userWith([['name' => 'releves', 'read' => true]]));
        $this->getJson('/app/get_plan?total=1000000')->assertUnprocessable();
    }

    public function test_login_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/app/admin_login', ['email' => 'limited@example.com'])->assertUnprocessable();
        }
        $this->postJson('/app/admin_login', ['email' => 'limited@example.com'])->assertStatus(429);
    }

    public function test_user_serialization_hides_credentials_and_reset_codes(): void
    {
        $user = new User;
        $user->forceFill(['password' => 'secret', 'passwordResetCode' => 'reset', 'activationCode' => 'activation']);
        $this->assertSame([], $user->toArray());
    }
}
