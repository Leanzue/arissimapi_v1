<?php

namespace App\Http\Controllers;

use App\Models\RequestType;
use App\Models\RequestStatus;
use App\Http\Requests\StoreRequestTypeRequest;
use App\Http\Requests\UpdateRequestTypeRequest;

class RequestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestTypes = RequestType::all();
        return $requestTypes;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestTypeRequest $request)
    {
        $requestType = RequestType::create([
            'action' => $request->action,
            'libellé' => $request->libellé,
        ]);
        return response()($requestType, 201);
    }

    /**
     * Display the specified resource.
     * @param RequestType $requestType
     * @param $request
     * @return
     */
    public function show(RequestType $requestType, $request)
    {
        return $requestType;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestType $requestType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequestTypeRequest $request
     * @param RequestType $requestType
     * @param $requestTypes
     * @return
     */
    public function update(UpdateRequestTypeRequest $request, RequestType $requestType, $requestTypes)
    {
        $requestType = RequestType::create([
            'action' => $request->action,
            'libellé' => $request->libellé,
        ]);
        return $requestTypes;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestType $requestType)
    {
        $requestType->delete();

        return null;
    }
}
