<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\UserSession;
use Carbon\Carbon;



class LogUserLogout
{
    public function handle(Logout $event)
    {
        $user = $event->user;
        
        // Get the latest session for the user (the one without logout_at)
        $session = $user->sessions()->whereNull('logout_at')->latest()->first();
        
        if ($session) {
            // Calculate session duration
            $duration = now()->diffInSeconds($session->login_at);
            
            // Update session with logout time and duration
            $session->update([
                'logout_at' => now(),
                'duration' => $duration,
            ]);
        }
    }
}

