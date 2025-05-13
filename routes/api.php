    <?php

    use App\Http\Controllers\PasswordResetController;
    use App\Http\Controllers\PasswordUpdateController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Foundation\Auth\EmailVerificationRequest;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\EventController;
    use App\Http\Controllers\TicketController;
    use App\Http\Controllers\ReservationController;
    use App\Http\Controllers\NotificationController;

    /*
    |--------------------------------------------------------------------------
    | Routes publiques
    |--------------------------------------------------------------------------
    */

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // ✅ Routes de vérification de compte
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); // Marque l'utilisateur comme vérifié
        return response()->json(['message' => 'E-mail vérifié avec succès']);
    })->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'E-mail déjà vérifié']);
        }

        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'E-mail de vérification renvoyé']);
    })->middleware(['auth:sanctum'])->name('verification.send');

    /*
    |--------------------------------------------------------------------------
    | Routes protégées (auth + email vérifié)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth:sanctum', 'verified'])->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        // Infos utilisateur connecté
        Route::get('/user', function (Request $request) {
            return $request->user()->load('roles');
        });

        /*
        |--------------------------------------------------------------------------
        | Routes pour ADMIN
        |--------------------------------------------------------------------------
        */
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/admin/stats', fn () => response()->json(['message' => 'Stats admin'])); // Exemple
        });

        /*
        |--------------------------------------------------------------------------
        | Routes pour ORGANISATEURS
        |--------------------------------------------------------------------------
        */
        Route::middleware(['role:organisateur'])->group(function () {
            Route::resource('/events', EventController::class)->only(['store', 'update', 'destroy']);
            Route::post('/events/{event}/tickets', [TicketController::class, 'store']);
            Route::put('/tickets/{ticket}', [TicketController::class, 'update']);
            Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy']);
        });

        /*
        |--------------------------------------------------------------------------
        | Routes pour PARTICIPANTS
        |--------------------------------------------------------------------------
        */
        Route::middleware(['role:participant'])->group(function () {
            Route::post('/events/{event}/reservations', [ReservationController::class, 'store']);
        });

        /*
        |--------------------------------------------------------------------------
        | Routes accessibles à tous les utilisateurs connectés
        |--------------------------------------------------------------------------
        */
        Route::get('/events', [EventController::class, 'index']);
        Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
        Route::get('/reservations', [ReservationController::class, 'index']);
        Route::put('/reservations/{reservation}', [ReservationController::class, 'update']);
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);

        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/{notification}/mark-sent', [NotificationController::class, 'markAsSent']);

        Route::get('/tickets/{ticket}/download', [TicketController::class, 'download']);
        Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
        Route::post('/reset-password', [PasswordResetController::class, 'reset']);

        Route::put('/me/password', [PasswordUpdateController::class, 'update'])
            ->middleware(['auth:sanctum']);
    });
