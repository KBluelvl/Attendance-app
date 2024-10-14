<?php

namespace App\Models;

use PDO; // Importation de PDO pour l'utilisation de méthodes spécifiques
use PDOException; // Importation de PDOException pour la gestion des erreurs
use \Illuminate\Support\Facades\DB; // Importation de DB pour la connexion à la base de données
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{

    protected $fillable = ['label', 'group_id'];

    public static function getAll() {
        try {
            // Obtient l'instance PDO via Laravel
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare("SELECT id, label, `group_id` FROM courses");
            $stmt->execute();
            // Récupère les résultats sous forme de tableau associatif
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $courses;

        } catch (PDOException $e) {
            // Gère les erreurs de connexion ou d'exécution de la requête
            echo 'Connection or query failed: ' . $e->getMessage();
            return [];
        }
    }

    // Relation avec le modèle Group
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}

