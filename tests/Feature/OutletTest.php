<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class OutletTest extends TestCase
{
    private $user;

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

        $this->user = User::query()->whereEmail('admin@example.com')->first();
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
     * Test list outlet can be displayed
     *
     * @return void
     */
    public function testListOutletPageCanBeDisplayed(): void
    {
        $response = $this->actingAs($this->user)->get('/outlets');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test create outlet can be displayed
     *
     * @return void
     */
    public function testCreateOutletPageCanBeDisplayed(): void
    {
        $response = $this->actingAs($this->user)->get('/outlets/create');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test outlet can be added
     *
     * @return void
     * @throws \JsonException
     */
    public function testOutletCanBeAdded(): void
    {
        $brand = Brand::query()->first();
        $countBeforeAdd = Outlet::query()->count();
        $response = $this->actingAs($this->user)->post('/outlets', [
            'brand_id' => $brand->id,
            'name' => 'Outlet test',
            'phone_number' => '0123456789',
            'description' => 'Outlet test',
            'address' => 'Indonesia'
        ]);

        $countAfterAdd = Outlet::query()->count();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/outlets');

        $this->assertEquals($countBeforeAdd + 1, $countAfterAdd);
    }

    /**
     * Test outlet can't be added error validation
     *
     * @return void
     */
    public function testOutletCantBeAddedErrorValidation(): void
    {
        $response = $this->actingAs($this->user)->post('/outlets', []);
        $response->assertRedirect()->assertSessionHasErrors([
            'brand_id',
            'name',
            'phone_number',
            'description',
            'address',
        ]);
    }

    /**
     * Test edit outlet can be displayed
     *
     * @return void
     */
    public function testEditOutletPageCanBeDisplayed(): void
    {
        $outlet = Outlet::query()->first();
        $response = $this->actingAs($this->user)->get('/outlets/edit/' . $outlet->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test outlet can be updated
     *
     * @return void
     * @throws \JsonException
     */
    public function testOutletCanBeUpdated(): void
    {
        $brand = Brand::query()->orderBy('created_at')->first();
        $outlet = Outlet::query()->create([
            'brand_id' => $brand->id,
            'name' => 'Outlet test',
            'phone_number' => '0123456789',
            'description' => 'Outlet test',
            'address' => 'Indonesia'
        ]);

        $newBrand = Brand::query()->orderByDesc('created_at')->first();
        $response = $this->actingAs($this->user)->put('/outlets/' . $outlet->id, [
            'brand_id' => $newBrand->id,
            'name' => 'Outlet test Edited',
            'phone_number' => '0123456798',
            'description' => 'Outlet test Edited',
            'address' => 'Indonesia Edited',
        ]);

        $outlet->refresh();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/outlets');

        $this->assertEquals($newBrand->id, $outlet->brand_id);
        $this->assertEquals('Outlet test Edited', $outlet->name);
        $this->assertEquals('0123456798', $outlet->phone_number);
        $this->assertEquals('Outlet test Edited', $outlet->description);
        $this->assertEquals('Indonesia Edited', $outlet->address);
    }

    /**
     * Test outlet can't be updated error validation
     *
     * @return void
     */
    public function testOutletCantBeUpdatedErrorValidation(): void
    {
        $outlet = Outlet::query()->first();
        $response = $this->actingAs($this->user)->put('/outlets/' . $outlet->id, []);
        $response->assertRedirect()->assertSessionHasErrors([
            'brand_id',
            'name',
            'phone_number',
            'description',
            'address',
        ]);
    }

    /**
     * Test outlet can be deleted
     *
     * @return void
     * @throws \JsonException
     */
    public function testOutletCanBeDeleted(): void
    {
        $outlet = Outlet::query()->first();
        $countBeforeDelete = Outlet::query()->count();

        $response = $this->actingAs($this->user)->delete('/outlets', [
            'outletId' => $outlet->id,
        ]);

        $countAfterDelete = Outlet::query()->count();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/outlets');

        $this->assertEquals($countBeforeDelete - 1, $countAfterDelete);
    }

    /**
     * Test get list outlet API
     *
     * @return void
     */
    public function testGetListOutletApi(): void
    {
        $outletCount = Outlet::query()->count();
        $response = $this->actingAs($this->user)
            ->json(
                'GET',
                '/api/outlets',
                [
                    'paginate' => 'false'
                ]
            );

        $response->assertOk()
            ->assertJsonCount($outletCount, 'data')
            ->assertJsonStructure([
                'status',
                'message',
                'data',
            ]);
    }

    /**
     * Test nearest outlet (below 25 kilometers)
     *
     * @return void
     */
    public function testGetNearestOutletApiBelow25(): void
    {
        // Get brand
        $brand = Brand::query()->first();

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

        $response = $this->actingAs($this->user)
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
                    'brand_name',
                    'name',
                    'phone_number',
                    'description',
                    'address',
                    'latitude',
                    'longitude',
                    'location_distance',
                ]
            ]);
    }

    /**
     * Test nearest outlet (above 25 kilometers)
     *
     * @return void
     */
    public function testGetNearestOutletApiAbove25(): void
    {
        // Get brand
        $brand = Brand::query()->first();

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

        $response = $this->actingAs($this->user)
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
