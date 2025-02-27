<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TreatmentAttempt\TreatmentStatus;
use App\Http\Requests\TreatmentStatus\StoreTreatmentStatusRequest;
use App\Http\Requests\TreatmentStatus\UpdateTreatmentStatusRequest;
use Maatwebsite\Excel\Facades\Excel;

class TreatmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $attemptstatuses = TreatmentStatus::all();
        return view('attemptstatuses.index', compact('attemptstatuses'));

    }

    public function create()
    {
        return view('attemptstatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreTreatmentStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTreatmentStatusRequest $request)
    {
        $attemptStatus = TreatmentStatus::create([
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
     * @param TreatmentStatus $attemptstatus
     * @return TreatmentStatus
     */
    public function show(TreatmentStatus $attemptstatus)
    {
        return $attemptstatus;
    }

    /**
     * Show the form for editing the specified resource.
     * @param TreatmentStatus $attemptstatus
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(TreatmentStatus $attemptstatuses)
    {
        return view('attemptstatuses.edit', compact('attemptstatuses'));
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateTreatmentStatusRequest $request
     * @param TreatmentStatus $attemptstatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTreatmentStatusRequest $request, TreatmentStatus $attemptstatus)
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
     * @param TreatmentStatus $attemptstatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TreatmentStatus $attemptstatus)
    {
        $attemptstatus->delete();
        return redirect()->route('attemptstatuses.index')->with('success', 'Attempt statuses deleted successfully');
    }
}
