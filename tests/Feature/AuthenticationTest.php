<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\MasterAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_master_admin_can_log_in_and_log_out(): void
    {
        $admin = User::factory()->create([
            'username' => 'admin1',
            'email' => 'admin@example.com',
            'password' => Hash::make('StrongPassword123!'),
        ]);
        $admin->role = User::ROLE_MASTER_ADMIN;
        $admin->save();

        $this->post('/login', [
            'username' => 'admin1',
            'password' => 'StrongPassword123!',
        ])->assertRedirect('/layanan');

        $this->assertAuthenticatedAs($admin);

        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_invalid_credentials_do_not_authenticate(): void
    {
        $this->post('/login', [
            'username' => 'admin1',
            'password' => 'incorrect',
        ])->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_for_the_admin_pages(): void
    {
        $this->get('/layanan')->assertRedirect('/login');
        $this->get('/layanan/create')->assertRedirect('/login');
    }

    public function test_non_admin_user_cannot_access_admin_pages_or_api(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/layanan')->assertForbidden();
        $this->getJson('/api/layanan')->assertForbidden();
    }

    public function test_api_requires_an_authenticated_master_admin(): void
    {
        $this->getJson('/api/layanan')->assertUnauthorized();
    }

    public function test_master_admin_seeder_creates_the_configured_admin_account(): void
    {
        config([
            'master_admin.name' => 'Master Admin',
            'master_admin.username' => 'admin1',
            'master_admin.email' => 'admin@example.com',
            'master_admin.password' => 'admin1',
        ]);

        app(MasterAdminSeeder::class)->run();

        $admin = User::where('username', 'admin1')->firstOrFail();

        $this->assertSame(User::ROLE_MASTER_ADMIN, $admin->role);
        $this->assertTrue(Hash::check('admin1', $admin->password));
    }
}
