<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::getAll();

        return response()->json($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'group_id' => 'required|integer|exists:groups,id', // Assurer que le group_id existe dans la table groups
        ]);

        // Si la validation échoue
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Créer un nouveau cours
            $course = Course::create([
                'label' => $request->label,
                'group_id' => $request->group_id,
            ]);

            // Retourner la réponse avec le cours créé
            return response()->json($course, 201); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // 400 Bad Request
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Récupérer tous les cours ayant le label spécifié
        $courses = Course::where('label', $id)->with('group')->get();

        // Vérifier si des cours ont été trouvés
        if ($courses->isEmpty()) {
            return response()->json(['message' => 'Aucun cours trouvé'], 404);
        }

        // Récupérer les groupes à partir des cours avec leurs ID et noms
    $groups = $courses->map(function ($course) {
        return [
            'id' => $course->group->id,
            'name' => $course->group->name,
        ];
    })->unique('id'); // Utiliser unique sur l'ID pour éviter les doublons

    // Vérifier si des groupes existent
    if ($groups->isEmpty()) {
        return response()->json(['message' => 'Aucun groupe trouvé pour ce cours'], 404);
    }

        // Retourner les noms des groupes sous forme de JSON
        return response()->json($groups, 200);
    }
    
    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            'label' => 'required|string|max:255',
            'group_id' => 'required|integer|exists:groups,id', // Assurer que le group_id existe dans la table groups
        ]);

        // Si la validation échoue
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Récupérer le cours à mettre à jour
            $course = Course::findOrFail($id);

            // Mettre à jour les informations du cours
            $course->update($request->only(['label', 'group_id']));

            // Retourner la réponse avec le cours mis à jour
            return response()->json($course, 200); // 200 OK
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Course not found'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // 400 Bad Request
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Récupérer le cours à supprimer
            $course = Course::findOrFail($id);

            // Supprimer le cours
            $course->delete();

            // Retourner une réponse de succès
            return response()->json(null, 204); // 204 No Content
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Course not found'], 404); // 404 Not Found
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); // 400 Bad Request
        }
    }
}
