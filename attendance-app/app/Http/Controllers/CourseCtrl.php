<?php

namespace App\Http\Controllers;
use App\Models\Course;

use Illuminate\Http\Request;

class CourseCtrl extends Controller
{
    public function index() {
        $courses = Course::getAll();
        return view('course', ['courses' => $courses]);
    }
}
