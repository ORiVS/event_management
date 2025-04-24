<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/events', EventController::class)->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    Route::post('/events/{event}/tickets', [TicketController::class, 'store']);
    Route::put('/tickets/{ticket}', [TicketController::class, 'update']); // Modifier un ticket
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']); // Annuler un ticket
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index']); // Lister les réservations
    Route::post('/events/{event}/reservations', [ReservationController::class, 'store']); // Réserver une place
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update']); // Modifier une réservation
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']); // Annuler une réservation
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{notification}/mark-sent', [NotificationController::class, 'markAsSent']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/tickets/{ticket}/download', [TicketController::class, 'download']);
