<?php
namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($notifications);
    }
}

