<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Brand/Index');
    }

    /**
     * Get all brands
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $brands = $this->brandRepo->index($request);
        return response()->json($brands);
    }

    /**
     * Create new brand
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Brand/Create');
    }

    /**
     * Store a new brand
     *
     * @param BrandRequest $request
     * @return RedirectResponse
     */
    public function store(BrandRequest $request): RedirectResponse
    {
        $this->brandRepo->store($request);
        return redirect()->route('brand.index');
    }

    /**
     * Edit brand
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $brand = $this->brandRepo->findOrFail($request->id);
        return Inertia::render('Brand/Edit', [
            'brand' => $brand,
        ]);
    }

    /**
     * Update a brand
     *
     * @param BrandRequest $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(BrandRequest $request, string $id): RedirectResponse
    {
        $brand = $this->brandRepo->findOrFail($id);
        $this->brandRepo->update($request, $brand);

        return redirect()->route('brand.index');
    }

    /**
     * Destroy a brand
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->brandRepo->destroy($request->brandId);
        return redirect()->route('brand.index');
    }
}
