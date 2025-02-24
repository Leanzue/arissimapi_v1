<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\RequestStatus;
use App\Http\Requests\RequestStatus\StoreRequestStatusRequest;
use App\Http\Requests\RequestStatus\UpdateRequestStatusRequest;


class RequestStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestStatuses = RequestStatus::all();
        return view('requeststatuses.index', compact('requestStatuses'));;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('requeststatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequestStatusRequest $request
     * @return
     */
    public function store(StoreRequestStatusRequest $request)
    {
        $requestStatus = RequestStatus::create([
            'uuid' => Str::uuid()->toString(),
            'priority' => $request->priority,
            'libellé' => $request->libellé,
        ]);

        return response()->json($requestStatus, 201);
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
        return view('requeststatuses.edit', compact('requestStatus'));
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
        return redirect()->route('requeststatuses.index')->with('success', 'Statut de demande supprimé avec succès.');
    }

}
