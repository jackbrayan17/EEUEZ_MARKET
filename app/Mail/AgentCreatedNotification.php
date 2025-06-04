<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgentCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $agent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $agent)
    {
        $this->agent = $agent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.agent.created')
                    ->subject('New Agent Created')
                    ->with(['agent' => $this->agent]);
    }
}
