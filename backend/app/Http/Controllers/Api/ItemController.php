<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ItemRequest;
use App\Services\ItemService;
use App\Http\Resources\ItemsResource;
use App\Repositories\ItemRepository;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $service;

    protected $repository;

    public function __construct(ItemService $service, ItemRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }
    public function index()
    {
        if (! Gate::check('viewAny Post')) {
            abort(HttpStatusCode::Forbidden->value, 'You do not have permission to view Post.');
        }

        return new ItemsResource($this->repository->fetch());
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(ItemRequest $request)
    {
        if (! Gate::check('create Post')) {
            abort(Response::HTTP_FORBIDDEN, 'You do not have permission to create a post.');
        }
        
        $item = $this->service->create($request->validated());

        if(! empty($this->service->error)) {
            abort($this->service->error['code'] ?? 500, $this->service->error['message'] ?? 'Sorry, something went wrong.');
        }
        return response()->json([
            'message' => 'Item created successfully',
            'item' => $item,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}