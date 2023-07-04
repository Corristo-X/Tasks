<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserDeactivated;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function deactivate(User $user)
    {
        $user->update(['is_active' => false]);
        $user->notify(new UserDeactivated($user->id));
        return response()->json($user, 201);
    }
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function activate(User $user)
    {
        $user->update(['is_active' => true]);

        return response()->json($user, 201);
    }

}
