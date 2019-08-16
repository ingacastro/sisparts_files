<?php
namespace IParts\Http;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DB;

class Helper {
    public static function sendMail($recipients, $subject, $message, $from, $reply_to)
    {
    	wordwrap($message, 70, "\r\n");

        $headers = 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $reply_to . "\r\n" .
		'X-Mailer: PHP/' . phpversion() . "\r\n" . 
		"Content-type: text/html\r\n";

		mail($recipients, $subject, $message, $headers);

    }
    public static function diffBusinessDays($start_date)
    {
        $start_date = new Carbon($start_date);
        $end_date = Carbon::parse(DB::select('select now() as current')[0]->current);

        $days = 0;
        $days += $start_date->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday() ? 1 : 0;
        }, $end_date);
        return $days;
    }
}