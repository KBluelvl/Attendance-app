<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseCtrl;
use App\Http\Controllers\PresenceCtrl;
use App\Http\Controllers\StudentCtrl;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PresenceController;

Route::get('/', [CourseCtrl::class, 'index']);
Route::get('/presence', [PresenceCtrl::class, 'index']);
Route::get('/presence/{courseId}', [PresenceCtrl::class, 'index'])->name('presence.index');
Route::post('/presence/{courseId}/submit', [PresenceCtrl::class, 'insertPresence'])->name('presence.submit');

Route::resource('/api/students', StudentCtrl::class);
Route::resource('/api/courses', CourseController::class);
Route::resource('/api/groups', GroupController::class);
Route::resource('/api/presences', PresenceController::class);