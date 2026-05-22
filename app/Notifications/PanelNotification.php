<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PanelNotification extends Notification
{
    use Queueable;

    /**
     * @param  array<int, string>  $channels  e.g. ['database'] for in-panel only
     */
    public function __construct(
        public string $title,
        public string $message,
        public ?string $url = null,
        public string $type = 'info',
        public array $channels = ['database', 'mail'],
        public ?string $module = null,
        public ?string $listKey = null,
    ) {}

    public function via(object $notifiable): array
    {
        return $this->channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->title)
            ->greeting('Hello ' . ($notifiable->name ?? 'there') . ',')
            ->line($this->message);

        if ($this->url) {
            $mail->action('View details', $this->url);
        }

        return $mail->line('Thank you for using ' . config('app.name') . '.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'type' => $this->type,
            'module' => $this->module,
            'list_key' => $this->listKey,
        ];
    }
}
