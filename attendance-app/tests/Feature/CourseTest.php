<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Course;

class CourseTest extends TestCase
{
    /**
     * Teste la création d'un nouveau cours et vérifie qu'un code 201 est retourné.
     */
    public function test_creates_a_new_course_and_returns_a_201_status_code(): void
    {
        // Envoie une requête POST à l'URL /api/courses pour créer un nouveau cours
        $response = $this->post('/api/courses', [
            'label' => 'Mathematics',
            'group_id' => 1,
        ]);

        // Vérifie que le code de statut de la réponse est 201 (Created)
        $response->assertStatus(201);

        // Supprime le cours créé pour nettoyer après le test
        $courseId = $response->json('id');
        $this->delete('/api/courses/' . $courseId);
    }

    /**
     * Teste la consultation de tous les cours et vérifie qu'une réponse 200 est retournée.
     */
    public function test_can_get_all_courses_and_returns_a_200_status_code(): void
    {
        // Envoie une requête GET à l'URL /api/courses
        $response = $this->get('/api/courses');

        // Vérifie que le code de statut de la réponse est 200 (OK)
        $response->assertStatus(200);
    }

    /**
     * Teste l'affichage d'un cours spécifique et vérifie qu'un code 200 est retourné.
     */
    public function test_can_show_a_course_and_returns_a_200_status_code(): void
    {
        // Crée un cours avec des valeurs prédéfinies
        $course = Course::create([
            'label' => 'History',
            'group_id' => 1,
        ]);

        // Envoie une requête GET à l'URL /api/courses/{id}
        $response = $this->get('/api/courses/' . $course->id);

        // Vérifie que le code de statut de la réponse est 200 (OK)
        $response->assertStatus(200);

        // Vérifie que la réponse contient bien les informations du cours
        $response->assertJson([
            'id' => $course->id,
            'label' => $course->label,
            'group_id' => $course->group_id,
        ]);

        // Supprime le cours après le test
        $course->delete();
    }

    /**
     * Teste la mise à jour d'un cours et vérifie qu'un code 200 est retourné.
     */
    public function test_can_update_course_and_returns_a_200_status_code(): void
    {
        // Crée un cours avec des valeurs prédéfinies
        $course = Course::create([
            'label' => 'Physics',
            'group_id' => 1,
        ]);

        // Envoie une requête PUT à l'URL /api/courses/{id} pour mettre à jour le cours
        $response = $this->put('/api/courses/' . $course->id, [
            'label' => 'Advanced Physics',
            'group_id' => 1,
        ]);

        // Vérifie que le code de statut de la réponse est 200 (OK)
        $response->assertStatus(200);

        // Vérifie que les données du cours ont été mises à jour
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'label' => 'Advanced Physics',
            'group_id' => 1,
        ]);

        // Supprime le cours après le test
        $course->delete();
    }

    /**
     * Teste la suppression d'un cours et vérifie qu'un code 204 est retourné.
     */
    public function test_can_delete_course_and_returns_a_204_status_code(): void
    {
        // Crée un cours avec des valeurs prédéfinies
        $course = Course::create([
            'label' => 'Chemistry',
            'group_id' => 1,
        ]);

        // Envoie une requête DELETE à l'URL /api/courses/{id} pour supprimer le cours
        $response = $this->delete('/api/courses/' . $course->id);

        // Vérifie que le code de statut de la réponse est 204 (No Content)
        $response->assertStatus(204);

        // Vérifie que le cours a été supprimé de la base de données
        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }
}