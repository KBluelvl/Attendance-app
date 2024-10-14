<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use Illuminate\Support\Facades\Validator;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presences = Presence::all();

        return response()->json($presences, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données d'entrée
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,matricule',
            'course_id' => 'required|exists:courses,id',
            'date' => 'nullable|date',
        ]);

        // Si la validation échoue
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Créer une nouvelle présence
            $presence = Presence::create([
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
                'date' => $request->date ?? now()->toDateString(),
            ]);

            // Retourner la réponse avec la nouvelle présence créée
            return response()->json($presence, 201);  // 201 Created
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);  // 400 Bad Request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
