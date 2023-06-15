<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\UserDeactivated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserDeactivatedNotificationTest extends TestCase
{
   // use RefreshDatabase;

    public function test_user_deactivated_notification()
    {
       // Notification::fake();

        $user = User::factory()->create();

        $user->deactivate($user);

        Notification::assertSentTo(
            $user,
            UserDeactivated::class,
            function ($notification, $channels) {
                return true;
            }
        );
    }
}
