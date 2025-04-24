<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return Notification::where('user_id', $request->user()->id)
            ->latest()
            ->get();
    }

    public function markAsSent(Notification $notification)
    {
        $notification->update([
            'status' => Notification::STATUS_SENT,
            'sent_at' => now(),
        ]);

        return response()->json(['message' => 'Notification marquée comme envoyée.']);
    }
}
