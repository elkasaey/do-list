<?php

namespace App\Http\Controllers;

use App\Models\dolist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDoListRequest;
use App\Http\Resources\DoListResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class DolistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): DoListResource
    {
        $taskList = dolist::orderBy('created_at', 'desc')->get();
        return DoListResource::collection($taskList);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): DoListResource
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoListRequest $request): DoListResource
    {
            $newtask = dolist::create($request->all());
            return new DoListResource($newtask);
    }

    /**
     * Display the specified resource.
     */
    public function show(dolist $dolist): DoListResource
    {
        return new DoListResource($dolist);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(dolist $dolist): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDoListRequest $request, dolist $dolist): RedirectResponse
    {
        $dolist->update($request->all());
        return new DoListResource($dolist);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(dolist $dolist): RedirectResponse
    {
        $dolist->delete();
        return response(null, 204);
    }
}
