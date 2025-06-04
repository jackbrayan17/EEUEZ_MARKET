<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\UserSession;
use Carbon\Carbon;

class LogUserLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;

        // Log the login event
        UserSession::create([
            'user_id' => $user->id,
            'login_at' => now(),
        ]);
    }
}
