<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface BrandRepositoryInterface
{
    /**
     * Get all brands
     *
     * @param Request $request
     * @return Collection|LengthAwarePaginator
     */
    public function index(Request $request): Collection|LengthAwarePaginator;

    /**
     * Find brand by ID
     *
     * @param string $brandId
     * @return Brand
     */
    public function findOrFail(string $brandId): Brand;

    /**
     * Store a new brand
     *
     * @param Request $request
     * @return Brand
     */
    public function store(Request $request): Brand;

    /**
     * Update a brand
     *
     * @param Request $request
     * @param Brand $brand
     * @return Brand
     */
    public function update(Request $request, Brand $brand): Brand;

    /**
     * Destroy a brand
     *
     * @param string $brandId
     * @return bool
     */
    public function destroy(string $brandId): bool;
}
