<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Auth::routes();

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});

Route::post('/register', 'App\Http\Controllers\RegisterController@register');
Route::post('/login', 'App\Http\Controllers\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\LoginController@logout');

Route::get('/get-all-emails-and-usn', 'App\Http\Controllers\LoginController@getAllEmailAndUSN');
Route::put('/get-fullname', 'App\Http\Controllers\LoginController@getFullname');
Route::get('/get-all-users', 'App\Http\Controllers\LoginController@getAllUsers');

Route::resource('subject', 'App\Http\Controllers\SubjectsController');
Route::put('/get-uploaded-subject-id', 'App\Http\Controllers\SubjectsController@getSubjectId');
Route::put('/get-subjects', 'App\Http\Controllers\SubjectsController@getSubjects');
Route::put('/get-subject-sem-branch', 'App\Http\Controllers\SubjectsController@getSubjectSemAndBranch');

Route::resource('notes', 'App\Http\Controllers\NotesController');
Route::put('/get-notes', 'App\Http\Controllers\NotesController@getNotes');
Route::put('/get-notes-link', 'App\Http\Controllers\NotesController@getNotesLink');

Route::resource('assignmentq', 'App\Http\Controllers\AssignmentQController');
Route::put('/get-assignmentq-link', 'App\Http\Controllers\AssignmentQController@getAssignmentQLink');

Route::resource('assignmenta', 'App\Http\Controllers\AssignmentAController');

Route::resource('announcements-and-queries', 'App\Http\Controllers\AandQController');

Route::resource('assessmentq', 'App\Http\Controllers\AssessmentQController');

Route::resource('assessmenta', 'App\Http\Controllers\AssessmentAController');

Route::resource('get-faculty-table', 'App\Http\Controllers\FacultyTableController');

Route::get('email/verify/{id}', 'App\Http\Controllers\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'App\Http\Controllers\VerificationController@resend')->name('verification.resend');

Route::post('password/email', 'App\Http\Controllers\ForgotPasswordController@forgot');
Route::post('password/reset', 'App\Http\Controllers\ForgotPasswordController@reset');