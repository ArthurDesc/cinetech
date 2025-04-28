<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe')
            ->greeting('Bonjour,')
            ->line("Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte sur Cinetech.")
            ->action('Réinitialiser mon mot de passe', $url)
            ->line('Ce lien de réinitialisation expirera dans '.config('auth.passwords.'.config('auth.defaults.passwords').'.expire').' minutes.')
            ->line("Si vous n'avez pas demandé de réinitialisation, aucune action supplémentaire n'est requise.")
            ->salutation('Cordialement, L\'équipe Cinetech');
    }
} 