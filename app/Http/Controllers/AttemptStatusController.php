<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AttemptStatus;
use App\Http\Requests\AttemptStatus\StoreAttemptStatusRequest;
use App\Http\Requests\AttemptStatus\UpdateAttemptStatusRequest;
use Maatwebsite\Excel\Facades\Excel;

class AttemptStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $attemptstatuses = AttemptStatus::all();
        return view('attemptstatuses.index', compact('attemptstatuses'));
    }

    public function create()
    {
        return view('attemptstatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreAttemptStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAttemptStatusRequest $request)
    {
        $attemptStatus = AttemptStatus::create([
            'uuid' => Str::uuid()->toString(),
            'nombre_essais' => $request->nombre_essais,
            'error_code' => $request->error_code,
            'details' => $request->details,
            'statut' => $request->statut,
            'comment' => $request->comment,
        ]);

        return response()->json($attemptStatus, 201);
    }

    /**
     * Display the specified resource.
     * @param AttemptStatus $attemptstatus
     * @return AttemptStatus
     */
    public function show(AttemptStatus $attemptstatus)
    {
        return $attemptstatus;
    }

    /**
     * Show the form for editing the specified resource.
     * @param AttemptStatus $attemptstatus
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(AttemptStatus $attemptstatuses)
    {
        return view('attemptstatuses.edit', compact('attemptstatuses'));
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateAttemptStatusRequest $request
     * @param AttemptStatus $attemptstatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAttemptStatusRequest $request, AttemptStatus $attemptstatus)
    {
        $attemptstatus->update([
            'uuid' => Str::uuid()->toString(),
            'nombre_essais' => $request->nombre_essais,
            'error_code' => $request->error_code,
            'details' => $request->details,
            'statut' => $request->statut,
            'comment' => $request->comment,
        ]);
        return redirect()->route('attemptstatuses.index');
    }


    /**
     * Remove the specified resource from storage.
     * @param AttemptStatus $attemptstatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AttemptStatus $attemptstatus)
    {
        $attemptstatus->delete();
        return redirect()->route('attemptstatuses.index')->with('success', 'Attempt statuses deleted successfully');
    }
}
