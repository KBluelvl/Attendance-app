<?php

namespace App\Http\Controllers;
use App\Models\Presence;

use Illuminate\Http\Request;

class PresenceCtrl extends Controller

{
    public function index($courseId) {
        $presences = Presence::getStudentsByCourse($courseId);
        return view('presence', [
            'presences' => $presences,
            'courseId' => $courseId, // Passer le courseId à la vue
        ]);
    }

    public function insertPresence(Request $request, $courseId) {
        $selectedStudents = $request->input('students'); // Les étudiants sélectionnés

        foreach ($selectedStudents as $matricule) {
            // Appel du modèle pour insérer la présence
            Presence::insertPresence($matricule, $courseId);
        }

        // Redirection après l'insertion ou autre action
        return redirect()->route('presence.index', ['courseId' => $courseId])->with('success', 'Présence enregistrée');
    }
}
