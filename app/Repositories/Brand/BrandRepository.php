<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BrandRepository implements BrandRepositoryInterface
{
    private $brandModel;

    /**
     * Constructor
     *
     * @param Brand $brandModel
     * @return void
     */
    public function __construct(Brand $brandModel)
    {
        $this->brandModel = $brandModel;
    }

    /**
     * Get all brands
     *
     * @param Request $request
     * @return Collection|LengthAwarePaginator
     */
    public function index(Request $request): Collection|LengthAwarePaginator
    {
        return $this->brandModel->withCount('outlets')->paginate(Brand::$defaultPerPage);
    }

    /**
     * Find brand by ID
     *
     * @param string $brandId
     * @return Brand
     */
    public function findOrFail(string $brandId): Brand
    {
        return $this->brandModel->whereId($brandId)->firstOrFail();
    }

    /**
     * Store a new brand
     *
     * @param Request $request
     * @return Brand
     */
    public function store(Request $request): Brand
    {
        return $this->brandModel->create($request->all());
    }

    /**
     * Update a brand
     *
     * @param Request $request
     * @param Brand $brand
     * @return Brand
     */
    public function update(Request $request, Brand $brand): Brand
    {
        $brand->update($request->all());
        return $brand->refresh();
    }

    /**
     * Destroy a brand
     *
     * @param string $brandId
     * @return bool
     */
    public function destroy(string $brandId): bool
    {
        return $this->brandModel->whereId($brandId)->delete();
    }
}
