<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentCtrl extends Controller 
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les étudiants depuis la base de données
        $students = Student::all();

        // Transformer la collection pour inclure le nom du groupe
        $studentsWithGroupNames = $students->map(function ($student) {
            return [
                'matricule' => $student->matricule,
                'name' => $student->name,
                'surname' => $student->surname,
                'group_id' => $student->group_id, // garder l'ID si nécessaire
                'group_name' => $student->group->name ?? 'No Group' // utilisation de l'opérateur null coalescent
            ];
        });

        // Retourner une réponse JSON avec les étudiants et un code 200
        return response()->json($studentsWithGroupNames, 200);
    }

    public function store(Request $request)
    {
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'matricule' => 'required|integer',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'group_id' => 'required|integer',
        ]);

        // Si la validation échoue, renvoie une réponse d'erreur
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Utiliser la méthode addStudent pour créer l'étudiant
            $student = Student::addStudent(
                $request->matricule,
                $request->name,
                $request->surname,
                $request->group_id
            );

            // Renvoie une réponse de succès
            return response()->json($student, 201); // Code 201 pour "created"
        } catch (\Exception $e) {
            // En cas d'erreur, renvoie une réponse d'erreur
            return response()->json(['error' => $e->getMessage()], 400); // Code 400 pour Bad Request
        }
    }

    public function show(string $groupName)
    {
        try {
            // Rechercher tous les étudiants appartenant au groupe avec le nom donné
            $students = Student::whereHas('group', function ($query) use ($groupName) {
                $query->where('name', $groupName);
            })->get();
    
            // Vérifier s'il y a des étudiants dans ce groupe
            if ($students->isEmpty()) {
                return response()->json(['message' => 'Aucun étudiant trouvé pour ce groupe'], 404);
            }
    
            // Retourner les étudiants sous forme de réponse JSON avec un statut 200
            return response()->json($students, 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse d'erreur avec un statut 500
            return response()->json(['error' => 'Erreur lors de la récupération des étudiants'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Valider les données de la requête
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'group_id' => 'required|integer',
        ]);

        // Si la validation échoue, renvoie une réponse d'erreur
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Récupérer l'étudiant à mettre à jour
            $student = Student::findOrFail($id);

            // Mettre à jour les informations de l'étudiant
            $student->update($request->only(['name', 'surname', 'group_id']));

            // Renvoie une réponse de succès
            return response()->json($student, 201); // Code 201 pour "indicates the successful creation of a new resource in response to a client's request"
        } catch (\Exception $e) {
            // En cas d'erreur, renvoie une réponse d'erreur
            return response()->json(['error' => $e->getMessage()], 400); // Code 400 pour Bad Request
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Rechercher l'étudiant par son matricule
            $student = Student::findOrFail($id);

            // Supprimer l'étudiant de la base de données
            $student->delete();

            // Renvoie une réponse de succès
            return response()->json(null, 204); // Code 204 pour No Content
        } catch (\Exception $e) {
            // En cas d'erreur, renvoie une réponse d'erreur
            return response()->json(['error' => $e->getMessage()], 400); // Code 400 pour Bad Request
        }
    }
}