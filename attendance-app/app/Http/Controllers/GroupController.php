<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Course;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupes = Group::all();

        return response()->json($groupes, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Récupérer le groupe par son ID
        $group = Group::find($id);

        // Vérifier si le groupe existe
        if (!$group) {
            return response()->json(['message' => 'Groupe non trouvé'], 404);
        }

        // Retourner le groupe en format JSON avec un statut 200 (OK)
        return response()->json($group, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Récupérer le groupe par son ID
        $group = Group::find($id);

        // Vérifier si le groupe existe
        if (!$group) {
            return response()->json(['message' => 'Groupe non trouvé'], 404);
        }

        // Validation des données entrantes pour la mise à jour
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Mettre à jour le groupe avec les nouvelles données
        $group->update($validatedData);

        // Retourner le groupe mis à jour en format JSON avec un statut 200 (OK)
        return response()->json($group, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Récupérer le groupe par son ID
        $group = Group::find($id);

        // Vérifier si le groupe existe
        if (!$group) {
            return response()->json(['message' => 'Groupe non trouvé'], 404);
        }

        // Supprimer le groupe
        $group->delete();

        // Retourner une réponse indiquant que la suppression s'est bien passée avec un statut 204 (Pas de contenu)
        return response()->json(null, 204);
    }
}
