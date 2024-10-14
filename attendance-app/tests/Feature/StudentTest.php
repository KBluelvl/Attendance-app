<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Student;

class StudentTest extends TestCase
{

    /**
     * A basic test example.
     */
    public function test_creates_a_new_student_and_returns_a_201_status_code(): void
    {
        $response = $this->post('/api/students', [
            'matricule' => 123456,
            'name' => 'SpongeBob',
            'surname' => 'SquarePants',
            'group_id' => 1,
        ]);

        $response->assertStatus(201);

        $this->delete('/api/students/123456');
    }

      /**
     * Teste la consultation de tous les étudiants et vérifie qu'une réponse 200 est retournée
     */
    public function test_can_get_all_students_and_returns_a_200_status_code(): void
    {
        // Effectue une requête GET à l'URL /api/students
        $response = $this->get('/api/students');

        // Vérifie que le code de statut de la réponse est 200 (OK)
        $response->assertStatus(200);
    }

    public function test_can_show_a_student_and_returns_a_200_status_code(): void
    {
        // Créer un étudiant avec des valeurs prédéfinies
        $student = Student::create([
            'matricule' => 2321321,
            'name' => 'fictif',
            'surname' => 'stu',
            'group_id' => 1,
        ]);
        

        // Envoie une requête GET à l'URL /api/students/{id}
        $response = $this->get('/api/students/' . $student->matricule);

        // Vérifie que le code de statut de la réponse est 200 (OK)
        $response->assertStatus(200);

        // Vérifie que la réponse contient bien les informations de l'étudiant
        $response->assertJson([
            'matricule' => $student->matricule,
            'name' => $student->name,
            'surname' => $student->surname,
            'group_id' => $student->group_id,
        ]);
        
        $this->delete('/api/students/2321321');
    }

    public function test_can_update_student_and_returns_a_201_status_code(): void
    {
        // Créer un étudiant avec des valeurs prédéfinies
        $student = Student::create([
            'matricule' => 321321,
            'name' => 'Initial Name',
            'surname' => 'Initial Surname',
            'group_id' => 1,
        ]);

        // Envoie une requête PUT à l'URL /api/students/{id} pour mettre à jour l'étudiant
        $response = $this->put('/api/students/' . $student->matricule, [
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'group_id' => 1,
        ]);

        // Vérifie que le code de statut de la réponse est 200 (OK)
        $response->assertStatus(201);

        // Vérifie que les données de l'étudiant ont été mises à jour
        $this->assertDatabaseHas('students', [
            'matricule' => $student->matricule,
            'name' => 'Updated Name',
            'surname' => 'Updated Surname',
            'group_id' => 1,
        ]);

        $this->delete('/api/students/321321');
    }

        public function test_can_delete_student_and_returns_a_204_status_code(): void
    {
        // Créer un étudiant avec des valeurs prédéfinies
        $student = Student::create([
            'matricule' => 43165156, // Assurez-vous que ce matricule est unique
            'name' => 'Student Name',
            'surname' => 'Student Surname',
            'group_id' => 1,
        ]);

        // Envoie une requête DELETE à l'URL /api/students/{id} pour supprimer l'étudiant
        $response = $this->delete('/api/students/' . $student->matricule);

        // Vérifie que le code de statut de la réponse est 204 (No Content)
        $response->assertStatus(204);

        // Vérifie que l'étudiant a été supprimé de la base de données
        $this->assertDatabaseMissing('students', [
            'matricule' => $student->matricule,
        ]);
    }
}