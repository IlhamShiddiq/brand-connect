<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class OutletFeatureTest extends TestCase
{
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

        // Create brand
        $brand = Brand::query()->create([
            'name' => 'Brand Testing',
            'description' => 'Brand for testing'
        ]);

        // Create outlets
        Outlet::query()->create([
            'brand_id' => $brand->id,
            'name' => 'Outlet Testing 1',
            'phone_number' => '081234567890',
            'description' => 'Outlet for testing',
            'address' => 'Bandung',
            'latitude' => -6.919538519557622,
            'longitude' => 107.56942009890771
        ]);

        Outlet::query()->create([
            'brand_id' => $brand->id,
            'name' => 'Outlet Testing 2',
            'phone_number' => '081098765432',
            'description' => 'Outlet for testing',
            'address' => 'Bandung',
            'latitude' => -6.901351546081368,
            'longitude' => 107.61920558050952
        ]);
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
     * Test nearest outlet (below 25 kilometers)
     *
     * @return void
     */
    public function testNearestOutletBelow25(): void
    {
        $userLoggedIn = User::query()->whereEmail('admin@example.com')->first();
        $response = $this->actingAs($userLoggedIn)
            ->json(
                'GET',
                '/api/outlets/nearest',
                [
                    'latitude' => -6.920318047219037,
                    'longitude' => 107.56979263376577
                ]
            );

        $response->assertOk()
            ->assertJsonPath('data.name', 'Outlet Testing 1')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'brand_id',
                    'name',
                    'slug',
                    'phone_number',
                    'description',
                    'address',
                    'latitude',
                    'longitude',
                    'created_at',
                    'updated_at',
                    'distance'
                ]
            ]);
    }

    /**
     * Test nearest outlet (above 25 kilometers)
     *
     * @return void
     */
    public function testNearestOutletAbove25(): void
    {
        $userLoggedIn = User::query()->whereEmail('admin@example.com')->first();
        $response = $this->actingAs($userLoggedIn)
            ->json(
                'GET',
                '/api/outlets/nearest',
                [
                    'latitude' => -6.082164994701605,
                    'longitude' => 106.39212165429926
                ]
            );

        $response->assertOk()
            ->assertJsonPath('data.name', null)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
            ]);
    }
}
