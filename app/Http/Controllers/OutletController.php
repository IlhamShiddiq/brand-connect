<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OutletRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Outlet\OutletRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OutletController extends Controller
{
    private $brandRepo, $outletRepo;

    /**
     * Constructor
     *
     * @param OutletRepositoryInterface $outletRepo
     * @return void
     */
    public function __construct(
        BrandRepositoryInterface $brandRepo,
        OutletRepositoryInterface $outletRepo
    )
    {
        $this->brandRepo = $brandRepo;
        $this->outletRepo = $outletRepo;
    }

    /**
     * Get all outlets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Outlet/Index');
    }

    /**
     * Get all outlets
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $outlets = $this->outletRepo->index($request);
        return response()->json($outlets);
    }

    /**
     * Create new outlet
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $brands = $this->brandRepo->index($request);
        return Inertia::render('Outlet/Create', [
            'brands' => $brands,
        ]);
    }

    /**
     * Store a new outlet
     *
     * @param OutletRequest $request
     * @return RedirectResponse
     */
    public function store(OutletRequest $request): RedirectResponse
    {
        $this->outletRepo->store($request);
        return redirect()->route('outlet.index');
    }

    /**
     * Edit outlet
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $outlet = $this->outletRepo->findOrFail($request->id);
        $brands = $this->brandRepo->index($request);

        return Inertia::render('Outlet/Edit', [
            'outlet' => $outlet,
            'brands' => $brands,
        ]);
    }

    /**
     * Update a outlet
     *
     * @param OutletRequest $request
     * @param string $outletId
     * @return RedirectResponse
     */
    public function update(OutletRequest $request, string $outletId): RedirectResponse
    {
        $outlet = $this->outletRepo->findOrFail($outletId);
        $updatedOutlet = $this->outletRepo->update($request, $outlet);

        return redirect()->route('outlet.index');
    }

    /**
     * Destroy a outlet
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->outletRepo->destroy($request->outletId);
        return redirect()->route('outlet.index');
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
