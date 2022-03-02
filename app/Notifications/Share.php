<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Share extends Notification
{
    use Queueable;

    private $share_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($share_id)
    {
        $this->share_id = $share_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'profile_photo_path' => Auth::user()->profile_photo_path,
            'share_id' => $this->share_id,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'profile_photo_path' => Auth::user()->profile_photo_path,
            'share_id' => $this->share_id,
        ]);
    }
}
