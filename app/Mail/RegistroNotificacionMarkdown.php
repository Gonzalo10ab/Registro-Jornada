<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class RegistroNotificacionMarkdown extends Mailable implements ShouldQueue

{
    use Queueable, SerializesModels;

    public $user;
    public $tipo;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $tipo)
    {
        $this->user = $user;
        $this->tipo = $tipo;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.registro_markdown')
                    ->subject("Fichaje registrado: {$this->tipo}")
                    ->with([
                        'user' => $this->user,
                        'tipo' => $this->tipo,
                        'fecha' => now()->format('d/m/Y H:i:s')
                    ]);
    }
}
