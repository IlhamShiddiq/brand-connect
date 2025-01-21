<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * Tear down
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Brand::query()->delete();
        Outlet::query()->delete();
        User::query()->delete();

        parent::tearDown();
    }

    /**
     * Test login screen can be rendered
     *
     * @return void
     */
    public function testLoginScreenCanBeRendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test user can authenticate using the login screen
     *
     * @return void
     */
    public function testUserCanAuthenticateUsingTheLoginScreen(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'Admin1234!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    /**
     * Test users can not authenticate with invalid password
     *
     * @return void
     */
    public function testUsersCanNotAuthenticateWithInvalidPassword(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * Test users can logout
     *
     * @return void
     */
    public function testUsersCanLogout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
