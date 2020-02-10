<?php

        $headers = 'From: compras@internationalparts.com.mx' . "\r\n" .
        'Reply-To: compras@internationalparts.com.mx'. "\r\n" .
		'X-Mailer: PHP/' . phpversion() . "\r\n" . 
		"Content-type: text/html";

		$result = mail('gmessoft@gmail.com', 'sendmail_test', 'message test', $headers);