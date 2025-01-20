<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brandRepo;

    /**
     * Constructor
     *
     * @param BrandRepositoryInterface $brandRepo
     * @return void
     */
    public function __construct(BrandRepositoryInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    /**
     * Get all brands
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $brands = $this->brandRepo->index($request);

        return response()->json([
            'status' => 200,
            'message' => 'Brands retrieved successfully',
            'data' => $brands,
        ]);
    }

    /**
     * Show a brand
     *
     * @param string $brandId
     * @return JsonResponse
     */
    public function show(string $brandId): JsonResponse
    {
        $brand = $this->brandRepo->findOrFail($brandId);

        return response()->json([
            'status' => 200,
            'message' => 'Brand retrieved successfully',
            'data' => $brand,
        ]);
    }

    /**
     * Store a new brand
     *
     * @param BrandRequest $request
     * @return JsonResponse
     */
    public function store(BrandRequest $request): JsonResponse
    {
        $newBrand = $this->brandRepo->store($request);

        return response()->json([
            'status' => 201,
            'message' => 'Brand created successfully',
            'data' => $newBrand,
        ], 201);
    }

    /**
     * Update a brand
     *
     * @param BrandRequest $request
     * @param string $brandId
     * @return JsonResponse
     */
    public function update(BrandRequest $request, string $brandId): JsonResponse
    {
        $brand = $this->brandRepo->findOrFail($brandId);
        $updatedBrand = $this->brandRepo->update($request, $brand);

        return response()->json([
            'status' => 200,
            'message' => 'Brand updated successfully',
            'data' => $updatedBrand,
        ], 200);
    }

    /**
     * Destroy a brand
     *
     * @param string $brandId
     * @return JsonResponse
     */
    public function destroy(string $brandId): JsonResponse
    {
        $this->brandRepo->destroy($brandId);

        return response()->json([
            'status' => 200,
            'message' => 'Brand deleted successfully',
        ], 200);
    }
}
