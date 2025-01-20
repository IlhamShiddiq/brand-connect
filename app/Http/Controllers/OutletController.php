<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OutletRequest;
use App\Repositories\Outlet\OutletRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    private $outletRepo;

    /**
     * Constructor
     *
     * @param OutletRepositoryInterface $outletRepo
     * @return void
     */
    public function __construct(OutletRepositoryInterface $outletRepo)
    {
        $this->outletRepo = $outletRepo;
    }

    /**
     * Get all outlets
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $outlets = $this->outletRepo->index($request);

        return response()->json([
            'status' => 200,
            'message' => 'Outlets retrieved successfully',
            'data' => $outlets,
        ]);
    }

    /**
     * Show a outlet
     *
     * @param string $outletId
     * @return JsonResponse
     */
    public function show(string $outletId): JsonResponse
    {
        $outlet = $this->outletRepo->findOrFail($outletId);

        return response()->json([
            'status' => 200,
            'message' => 'Outlet retrieved successfully',
            'data' => $outlet,
        ]);
    }

    /**
     * Store a new outlet
     *
     * @param OutletRequest $request
     * @return JsonResponse
     */
    public function store(OutletRequest $request): JsonResponse
    {
        $newOutlet = $this->outletRepo->store($request);

        return response()->json([
            'status' => 201,
            'message' => 'Outlet created successfully',
            'data' => $newOutlet,
        ], 201);
    }

    /**
     * Update a outlet
     *
     * @param OutletRequest $request
     * @param string $outletId
     * @return JsonResponse
     */
    public function update(OutletRequest $request, string $outletId): JsonResponse
    {
        $outlet = $this->outletRepo->findOrFail($outletId);
        $updatedOutlet = $this->outletRepo->update($request, $outlet);

        return response()->json([
            'status' => 200,
            'message' => 'Outlet updated successfully',
            'data' => $updatedOutlet,
        ], 200);
    }

    /**
     * Destroy a outlet
     *
     * @param string $outletId
     * @return JsonResponse
     */
    public function destroy(string $outletId): JsonResponse
    {
        $this->outletRepo->destroy($outletId);

        return response()->json([
            'status' => 200,
            'message' => 'Outlet deleted successfully',
        ], 200);
    }

    /**
     * Find the nearest outlet
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function findTheNearest(Request $request): JsonResponse
    {
        $outlet = $this->outletRepo->findTheNearest($request);

        return response()->json([
            'status' => 200,
            'message' => 'Outlet retrieved successfully',
            'data' => $outlet,
        ]);
    }
}
