<?php

namespace App\Listeners;

use App\Mail\Invoice;
use App\Events\InvoiceCreated;
use Illuminate\Support\Facades\Mail;
use App\Notifications\InvoiceCreation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        Notification::send($event->users, new InvoiceCreation($event->invoice));
        //send email to the admin that there is new attachment added
        Mail::to(env('ADMIN_MAIL'))->send(new Invoice($event->invoice));
    }
}
