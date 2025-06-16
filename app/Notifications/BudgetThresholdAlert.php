<?php

namespace App\Notifications;

use App\Models\Budget;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class BudgetThresholdAlert extends Notification
{
    use Notifiable;

    protected Budget $budget;

    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('⚠️ Budget Low Alert')
            ->greeting('Hi ' . $notifiable->name)
            ->line("Your budget for {$this->budget->category->name} in {$this->budget->month}/{$this->budget->year} is running low.")
            ->line('Please keep this in mind for future spending')
            ->salutation('Thank you!');
    }
}
