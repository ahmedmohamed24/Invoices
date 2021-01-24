<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoiceCreation extends Notification implements ShouldQueue
{
    use Queueable;
    public Invoice $invoice;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }
    public function toDatabase()
    {
        return [
            'link' => route('invoice.show', $this->invoice->id),
            'created_at' => Carbon::now(),
            'Description' => 'new Invoice created by ' . Auth::user()->name,
        ];
    }
}
