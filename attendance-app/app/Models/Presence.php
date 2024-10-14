<?php

namespace App\Models;

use PDO; // Importation de PDO pour l'utilisation de méthodes spécifiques
use PDOException; // Importation de PDOException pour la gestion des erreurs
use \Illuminate\Support\Facades\DB; // Importation de DB pour la connexion à la base de données
use Illuminate\Database\Eloquent\Model;

class Presence extends Model 
{
    protected $fillable = ['student_id','course_id','date'];

    public static function insertPresence($matricule, $courseId) {
        $currentDate = date('Y-m-d'); // Date actuelle

        // Vérifier si une présence a déjà été enregistrée pour ce cours et cette date
        $existingPresence = DB::table('presence')
            ->where('student', $matricule)
            ->where('course_id', $courseId)
            ->where('date', $currentDate)
            ->exists();

        if ($existingPresence) {
            return false; // Indique que la présence existe déjà
        }

        DB::table('presence')->insert([
            'student' => $matricule,
            'course_id'  => $courseId,
            'date'    => now(),
        ]);
        return true;
    }
    
    public static function getStudentsByCourse($courseId) {
        try {
            // Obtient l'instance PDO via Laravel
            $pdo = DB::getPdo();

            // Étape 1 : Récupérer le groupe associé au cours
            $stmt = $pdo->prepare("
                SELECT `group_id`
                FROM courses
                WHERE id = ?
            ");
            $stmt->execute([$courseId]);
            $group = $stmt->fetchColumn();

            if (!$group) {
                // Si aucun groupe n'est trouvé, on retourne une liste vide
                return [];
            }

            // Étape 2 : Récupérer les étudiants appartenant au groupe et trier par matricule
            $stmt = $pdo->prepare("
                SELECT students.matricule, students.name, students.surname
                FROM students
                WHERE students.group_id = ?
                ORDER BY students.matricule
            ");
            $stmt->execute([$group]);

            // Récupère les résultats sous forme de tableau associatif
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $students;

        } catch (PDOException $e) {
            // Gère les erreurs de connexion ou d'exécution de la requête
            echo 'Connection or query failed: ' . $e->getMessage();
            return [];
        }
    }
}



