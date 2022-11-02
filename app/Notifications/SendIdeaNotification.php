<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendIdeaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $ideas;
    protected $ideaDate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $ideas, $ideaDate)
    {
        $this->user = $user;
        $this->ideas = $ideas;
        $this->ideaDate = $ideaDate;
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
        $time = strtotime($this->ideaDate);
        $month = date("F", $time);
        $year = date("Y", $time);

        $links = '';

        foreach ($this->ideas as $index => $idea) {
            $lineNo = $index + 1;
            $url = route('dashboard.idea.show', $idea->uuid);
            $links .= "<p>$lineNo: <a style='text-decoration: none' href='$url'>$idea->title</a></p>";
        }
        return (new MailMessage)
            ->subject(config('app.name') . ' - Short-Listed Ideas')
            ->greeting('Hello ' . $this->user->first_name . ' ' . $this->user->last_name . '!')
            ->line('These are the shortlisted idea for( ' . $month . ',' . $year . '). You can click individual to see in detail and give feedback.')
            ->line($links)
            // ->view('email.sendIdeaMail', ['ideas' => $this->ideas])
            ->line('Thank you for using our application!');
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