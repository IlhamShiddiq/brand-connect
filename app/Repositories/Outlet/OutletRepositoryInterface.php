<?php

namespace App\Repositories\Outlet;

use App\Models\Outlet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface OutletRepositoryInterface
{
    /**
     * Get all outlets
     *
     * @param Request $request
     * @return Collection|LengthAwarePaginator
     */
    public function index(Request $request): Collection|LengthAwarePaginator;

    /**
     * Find outlet by ID
     *
     * @param string $outletId
     * @return Outlet
     */
    public function findOrFail(string $outletId): Outlet;

    /**
     * Store a new outlet
     *
     * @param Request $request
     * @return Outlet
     */
    public function store(Request $request): Outlet;

    /**
     * Update an outlet
     *
     * @param Request $request
     * @param Outlet $outlet
     * @return Outlet
     */
    public function update(Request $request, Outlet $outlet): Outlet;

    /**
     * Destroy an outlet
     *
     * @param string $outletId
     * @return bool
     */
    public function destroy(string $outletId): bool;
}
