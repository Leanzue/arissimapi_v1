<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use App\Models\SimRequest\RequestType;
use App\Http\Requests\RequestType\StoreRequestTypeRequest;
use App\Http\Requests\RequestType\UpdateRequestTypeRequest;

class RequestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestTypes = RequestType::all();
        return view('requestTypes.index', compact('requestTypes'));;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('requestTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequestTypeRequest $request
     * @return
     */
    public function store(StoreRequestTypeRequest $request)
    {
        $requestType = RequestType::create([
            'uuid' => Str::uuid()->toString(),
            'action' => $request->input('action'),
            'libellé' => $request->input('libellé'),
            'status_id' => $request->input('status_id'),
        ]);
        return response()->json($requestType, 201);
    }

    /**
     * Display the specified resource.
     * @param RequestType $requestType
     * @return RequestType
     */
    public function show(RequestType $requestType)
    {
        return $requestType;
    }

    /**
     * Show the form for editing the specified resource.
     * @param RequestType $requestTypes
     * @return \Illuminate\Container\Container|\Illuminate\Container\TClass|object
     */
    public function edit(RequestType $requestTypes)
    {
        return view('requestTypes.edit', compact('requestTypes'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequestTypeRequest $request
     * @param RequestType $requestType
     * @return
     */
    public function update(UpdateRequestTypeRequest $request, RequestType $requestType)
    {
        $requestType->update([
            'action' => $request->input('action'),
            'libellé' => $request->input('libellé'),
            'status_id' => $request->input('status_id'),
        ]);
        return response()->json($requestType, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestType $requestType)
    {
        $requestType->delete();
        return response()->json(['success' => true, 'message' => 'Un type de requête supprimé avec succès.']);
    }

}
