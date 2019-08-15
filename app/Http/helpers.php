<?php
namespace IParts\Http;

use Illuminate\Support\Facades\Log;

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
}