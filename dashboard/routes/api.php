<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// These will automatically get /api prefix
Route::get('/exams', [ExamController::class, 'getExams']);
Route::post('/exams', [ExamController::class, 'store']);
Route::get('/exams/{id}', [ExamController::class, 'show']);
Route::put('/exams/{id}', [ExamController::class, 'update']);
Route::delete('/exams/{id}', [ExamController::class, 'destroy']);
Route::post('/exams/import-csv', [ExamController::class, 'importCSV']);
