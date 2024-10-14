<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Student;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    public function test_it_can_add_a_student_successfully()
    {
        // Ajoute un étudiant avec un matricule, nom, prénom et group_id
        $student = Student::addStudent(1894984, 'SpongeBob', 'SquarePants', 1);

        // Vérifie si l'étudiant a été ajouté à la base de données
        $this->assertDatabaseHas('students', [
            'matricule' => 1894984,
            'name' => 'SpongeBob',
            'surname' => 'SquarePants',
            'group_id' => 1
        ]);
        $this->delete('/api/students/1894984');
    }

    public function test_it_throws_exception_for_negative_matricule()
    {
        // On s'attend à une exception pour matricule négatif
        $this->expectException(\InvalidArgumentException::class);

        // Tentative d'ajout d'un étudiant avec un matricule négatif
        Student::addStudent(-1, 'SpongeBob', 'SquarePants', 1);
    }

    protected function setUp(): void
    {
        parent::setUp(); // Appelle le setUp parent pour s'assurer que tout est bien initialisé

        // Ajout d'un étudiant pour le test
        Student::addStudent(76546, 'SpongeBob', 'SquarePants', 1);
    }

    protected function tearDown(): void
    {
        // Supprime l'étudiant ajouté pour nettoyer après le test
        Student::where('matricule', 76546)->delete();

        parent::tearDown(); // Appelle le tearDown parent
    }

    public function test_it_throws_exception_for_duplicate_matricule()
    {
        // On s'attend à une exception lors de l'ajout d'un deuxième étudiant avec le même matricule
        $this->expectException(\Exception::class);

        // Tentative d'ajout d'un étudiant avec un matricule déjà existant
        Student::addStudent(76546, 'SpongeBob', 'SquarePants', 2);
    }
}
