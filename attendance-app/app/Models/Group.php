<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];

    /**
     * Relation avec les étudiants
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'group_id');
    }

    /**
     * Relation avec les cours
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
