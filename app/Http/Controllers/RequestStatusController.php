<?php

namespace App\Http\Controllers;

use App\Models\RequestStatus;
use App\Http\Requests\StoreRequestStatusRequest;
use App\Http\Requests\UpdateRequestStatusRequest;

class RequestStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestStatuses = RequestStatus::all();
        return $requestStatuses;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestStatusRequest $request)
    {
        $requestStatus = RequestStatus::create([
            'priority' => $request->priority,
            'libellé' => $request->libellé,
        ]);

        return response()(requestStatus, 201);
    }

    /**
     * Display the specified resource.
     * @param RequestStatus $requestStatus
     * @param $requestStatuses
     * @return
     */
    public function show(RequestStatus $requestStatus, $requestStatuses)
    {
        return $requestStatuses;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestStatus $requestStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequestStatusRequest $request
     * @param RequestStatus $requestStatus
     * @param $requestStatuses
     * @return
     */
    public function update(UpdateRequestStatusRequest $request, RequestStatus $requestStatus, $requestStatuses)
    {

        $requestStatus->update([
            'priority' => $request->priority,
            'libellé' => $request->libellé,
        ]);

        return $requestStatuses;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestStatus $requestStatus)
    {
        $requestStatus->delete();
        return null;
    }
}
