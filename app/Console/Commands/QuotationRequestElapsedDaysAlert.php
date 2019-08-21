<?php

namespace IParts\Console\Commands;

use Illuminate\Console\Command;
use IParts\Http\Helper;
use IParts\Alert;
use IParts\SupplySet;
use Illuminate\Support\Facades\Log;
use DB;

class QuotationRequestElapsedDaysAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotation-request:elapsed-days-alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies a email list when a quotation request has reached the elapsed days specified in the alert.';

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
     * @return mixed
     */
    public function handle()
    {
        $quotation_request_sets = SupplySet::whereIn('status', [2, 3])->get();
        $alerts = Alert::where('type', 1)->orderBy('elapsed_days', 'DESC')->get();
        foreach($quotation_request_sets as $set) {
            $document = $set->document;
            foreach($alerts as $alert) {
                $elapsed_days = Helper::diffBusinessDays($set->quotation_request_date);
                if($elapsed_days == $alert->elapsed_days) 
                    $subject = $alert->subject . ' PCT'  . $document->number . ' ' . $document->reference;
                    Helper::sendMail($alert->recipients, $subject, $alert->message, 'admin@admin.com', null);
            }
        }
    }
}
