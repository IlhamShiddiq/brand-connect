<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProfileTest extends TestCase
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
     * Test profile page is displayed
     *
     * @return void
     */
    public function testProfilePageIsDisplayed(): void
    {
        $user = User::query()->whereEmail('admin@example.com')->first();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    /**
     * Test profile information can be updated
     *
     * @return void
     * @throws \JsonException
     */
    public function testProfileInformationCanBeUpdated(): void
    {
        $user = User::query()->whereEmail('admin@example.com')->first();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }
}
