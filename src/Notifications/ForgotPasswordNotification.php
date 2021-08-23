<?php

namespace Rodrigorioo\BackStrapLaravel\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Rodrigorioo\BackStrapLaravel\Models\Administrator;

class ForgotPasswordNotification extends Notification
{
    protected $administrator;
    protected $token;

    public function __construct(Administrator $administrator, $token)
    {
        $this->administrator = $administrator;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $prefix = config('backstrap_laravel.prefix');
        $passwordResetUrl = config('backstrap_laravel.password_reset_url');

        return (new MailMessage)
            ->line("Hola {$this->administrator->name}, por favor dirigite al siguiente link para cambiar tu contraseña")
            ->action('Cambiar contraseña', url($prefix."/".$passwordResetUrl.'?token='.$this->token));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}