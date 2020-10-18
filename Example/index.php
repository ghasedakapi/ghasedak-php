<?php

require __DIR__ . '/../src/GhasedakApi.php';

try {

    $message = "Hello, World!"; // message
    $lineNumber = null; // If you do not have a dedicated line, you must specify the line number
    $receptor = "09xxxxxxxxx"; // receptor

    $api = new \Ghasedak\GhasedakApi('your_api_key'); // change the key with your API key which you've got form your Ghasedak account
    $api->SendSimple($receptor,$message,$lineNumber);

} catch(\Ghasedak\Exceptions\ApiException $e){
    echo $e->errorMessage();
} catch(\Ghasedak\Exceptions\HttpException $e){
    echo $e->errorMessage();
}