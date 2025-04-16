<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ItemRequest;
use App\Services\ItemService;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $service;

    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        //
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