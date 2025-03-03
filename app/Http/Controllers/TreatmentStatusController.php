<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Treatment\TreatmentStatus;
use App\Http\Requests\TreatmentStatus\StoreTreatmentStatusRequest;
use App\Http\Requests\TreatmentStatus\UpdateTreatmentStatusRequest;


class TreatmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $treatmentstatuses = TreatmentStatus::all();
        return view('treatmentstatuses.index', compact('treatmentstatuses'));

    }

    public function create()
    {
        return view('treatmentstatuses.create');
    }

    /**
     * @param StoreTreatmentStatusRequest $request
     * @return mixed
     */
    public function store(StoreTreatmentStatusRequest $request)
    {
        $treatmentstatus = TreatmentStatus::create([
            'uuid' => Str::uuid()->toString(),
            'code' => $request->code,
            'libelle' => $request->libelle,
            'description' => $request->description,
        ]);

        return response()->json($treatmentstatus, 201);
    }

    /**
     * Display the specified resource.
     * @param TreatmentStatus $treatmentstatus
     * @return TreatmentStatus
     */
    public function show(TreatmentStatus $treatmentstatus)
    {
        return $treatmentstatus;
    }

    /**
     * Show the form for editing the specified resource.
     * @param TreatmentStatus $treatmentstatus
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(TreatmentStatus $treatmentstatuses)
    {
        return view('treatmentstatuses.edit', compact('treatmentstatuses'));
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateTreatmentStatusRequest $request
     * @param TreatmentStatus $treatmentstatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTreatmentStatusRequest $request, TreatmentStatus $treatmentstatus)
    {
        $treatmentstatus->update([
            'uuid' => Str::uuid()->toString(),
            'code' => $request->code,
            'libelle' => $request->libelle,
            'description' => $request->description,
        ]);
        return redirect()->route('treatmentstatuses.index');
    }


    /**
     * Remove the specified resource from storage.
     * @param TreatmentStatus $treatmentstatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(TreatmentStatus $treatmentstatuses)
    {
        $treatmentstatuses->delete();
        return redirect()->route('treatmentstatuses.index')->with('success', 'Attempt statuses deleted successfully');
    }
}
