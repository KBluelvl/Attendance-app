<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    // Le tableau $fillable permet de définir les attributs qui peuvent être assignés en masse
    protected $fillable = ['matricule', 'name', 'surname', 'group_id'];

    // Spécifier que la clé primaire n'est pas un ID auto-incrémenté
    protected $primaryKey = 'matricule';

    // Désactiver les auto-incréments car "matricule" est défini manuellement
    public $incrementing = false;

    // Le type de clé primaire est un entier non signé
    protected $keyType = 'unsignedBigInteger';

    public static function addStudent($matricule, $name, $surname, $group_id)
    {
        // Vérification si le matricule est négatif
        if ($matricule < 0) {
            throw new \InvalidArgumentException("Student matricule cannot be negative.");
        }

        // Vérification si un étudiant avec le même matricule existe déjà
        if (self::where('matricule', $matricule)->exists()) {
            throw new \Exception("Student matricule already exists.");
        }

        // Création de l'étudiant
        return self::create([
            'matricule' => $matricule,
            'name' => $name,
            'surname' => $surname,
            'group_id' => $group_id
        ]);
    }

    /**
     * Relation avec le modèle Group (groupe d'étudiants)
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
