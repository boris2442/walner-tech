<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegistered extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Delivery channels: mail + database
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Mail representation
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvel utilisateur inscrit')
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Un nouvel utilisateur vient de s'inscrire :")
            ->line("Nom : {$this->user->name}")
            ->line("Email : {$this->user->email}")
            ->line("Téléphone : {$this->user->phone}")
            ->line("Rôle : {$this->user->role}")
            ->line('Connectez-vous au dashboard pour plus de détails.');
    }

    /**
     * Database representation
     */
    public function toDatabase($notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'role' => $this->user->role,
            'message' => "Un nouvel utilisateur s'est inscrit.",
        ];
    }
}
