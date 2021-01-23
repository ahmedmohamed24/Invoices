<?php

namespace App\Console\Commands;

use App\Events\MostlyExpiredInvoices;
use App\Models\Invoice;
use Illuminate\Console\Command;

class NotifyBeforeDueDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:notifyBeforeDueDate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notify admin before the due date of the invoice by one weak for every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $nearlyDueDates = Invoice::where('due_date', '<=', \Carbon\Carbon::now()->addWeek()->toDateTimeString())->where('due_date', '>', \Carbon\Carbon::now()->toDateTimeString())->get();
        event(new MostlyExpiredInvoices($nearlyDueDates));
    }
}
