<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $payload)
    {
        $file = $payload->file;
        $payload['file_path'] = $file->getPath();
        $payload['file_name'] = $file->getClientOriginalName();
        $payload['file_type'] = $file->getClientMimeType();
        $payload['name'] = $payload['name'] ?? $file->getClientOriginalName();
        unset($payload['file']);

        
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
