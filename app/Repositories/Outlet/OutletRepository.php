<?php

namespace App\Repositories\Outlet;

use App\Models\Outlet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class OutletRepository implements OutletRepositoryInterface
{
    private $outletModel;

    /**
     * Constructor
     *
     * @param Outlet $outletModel
     * @return void
     */
    public function __construct(Outlet $outletModel)
    {
        $this->outletModel = $outletModel;
    }

    /**
     * Get all outlets
     *
     * @param Request $request
     * @return Collection|LengthAwarePaginator
     */
    public function index(Request $request): Collection|LengthAwarePaginator
    {
        return $this->outletModel
            ->with(['brand:id,name'])
            ->when(
                $request->paginate === 'false',
                function ($q) {
                    return $q->get();
                },
                function ($q) {
                    return $q->paginate(Outlet::$defaultPerPage);
                }
            );
    }

    /**
     * Find outlet by ID
     *
     * @param string $outletId
     * @return Outlet
     */
    public function findOrFail(string $outletId): Outlet
    {
        return $this->outletModel->whereId($outletId)->firstOrFail();
    }

    /**
     * Find the nearest outlet (below 25 kilometers))
     *
     * @param Request $request
     * @return Outlet|null
     */
    public function findTheNearest(Request $request): ?Outlet
    {
        $userLat = $request->latitude;
        $userLong = $request->longitude;

        return $this->outletModel
            ->getNearest($userLat, $userLong)
            ->with([
                'brand:id,name'
            ])
            ->orderBy('distance')->first();
    }

    /**
     * Store a new outlet
     *
     * @param Request $request
     * @return Outlet
     */
    public function store(Request $request): Outlet
    {
        return $this->outletModel->create($request->all());
    }

    /**
     * Update an outlet
     *
     * @param Request $request
     * @param Outlet $outlet
     * @return Outlet
     */
    public function update(Request $request, Outlet $outlet): Outlet
    {
        $outlet->update($request->all());
        return $outlet->refresh();
    }

    /**
     * Destroy an outlet
     *
     * @param string $outletId
     * @return bool
     */
    public function destroy(string $outletId): bool
    {
        return $this->outletModel->whereId($outletId)->delete();
    }
}
