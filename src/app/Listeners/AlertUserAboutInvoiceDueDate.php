<?php

namespace App\Listeners;

use App\Events\MostlyExpiredInvoices;
use App\Mail\InvoiceDueDate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class AlertUserAboutInvoiceDueDate
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
     * @param  MostlyExpiredInvoices  $event
     * @return void
     */
    public function handle(MostlyExpiredInvoices $event)
    {
        // $event->invoices;
        Mail::to(env('ADMIN_MAIL'))->send(new InvoiceDueDate($event->invoices));
    }
}
