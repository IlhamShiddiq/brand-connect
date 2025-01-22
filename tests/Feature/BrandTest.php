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

class BrandTest extends TestCase
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
     * Test list brand can be displayed
     *
     * @return void
     */
    public function testListBrandPageCanBeDisplayed(): void
    {
        $response = $this->actingAs($this->user)->get('/brands');

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test create brand can be displayed
     *
     * @return void
     */
    public function testCreateBrandPageCanBeDisplayed(): void
    {
        $response = $this->actingAs($this->user)->get('/brands/create');

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test brand can be added
     *
     * @return void
     * @throws \JsonException
     */
    public function testBrandCanBeAdded(): void
    {
        $countBeforeAdd = Brand::query()->count();
        $response = $this->actingAs($this->user)->post('/brands', [
            'name' => 'Brand test',
            'description' => 'Brand test',
        ]);

        $countAfterAdd = Brand::query()->count();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/brands');

        $this->assertEquals($countBeforeAdd + 1, $countAfterAdd);
    }

    /**
     * Test brand can't be added error validation
     *
     * @return void
     */
    public function testBrandCantBeAddedErrorValidation(): void
    {
        $response = $this->actingAs($this->user)->post('/brands', []);
        $response->assertRedirect()->assertSessionHasErrors(['name', 'description']);
    }

    /**
     * Test edit brand can be displayed
     *
     * @return void
     */
    public function testEditBrandPageCanBeDisplayed(): void
    {
        $brand = Brand::query()->first();
        $response = $this->actingAs($this->user)->get('/brands/edit/' . $brand->id);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test brand can be updated
     *
     * @return void
     * @throws \JsonException
     */
    public function testBrandCanBeUpdated(): void
    {
        $brand = Brand::query()->create([
            'name' => 'Brand test',
            'description' => 'Brand test',
        ]);

        $response = $this->actingAs($this->user)->put('/brands/' . $brand->id, [
            'name' => 'Brand test 2',
            'description' => 'Brand test 2',
        ]);

        $brand->refresh();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/brands');

        $this->assertEquals('Brand test 2', $brand->name);
        $this->assertEquals('Brand test 2', $brand->description);
    }

    /**
     * Test brand can't be updated error validation
     *
     * @return void
     */
    public function testBrandCantBeUpdatedErrorValidation(): void
    {
        $brand = Brand::query()->create([
            'name' => 'Brand test',
            'description' => 'Brand test',
        ]);

        $response = $this->actingAs($this->user)->put('/brands/' . $brand->id, []);
        $response->assertRedirect()->assertSessionHasErrors(['name', 'description']);
    }

    /**
     * Test brand can be deleted
     *
     * @return void
     * @throws \JsonException
     */
    public function testBrandCanBeDeleted(): void
    {
        $brand = Brand::query()->first();
        $countBeforeDelete = Brand::query()->count();

        $response = $this->actingAs($this->user)->delete('/brands', [
            'brandId' => $brand->id,
        ]);

        $countAfterDelete = Brand::query()->count();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/brands');

        $this->assertEquals($countBeforeDelete - 1, $countAfterDelete);
    }
}
