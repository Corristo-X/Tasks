<?php
namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationsController extends Controller
{
    public function index($userId)  // Dodanie parametru $userId
    {
        $notifications = Notification::where('notifiable_id', $userId)->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($notifications);
    }
}
