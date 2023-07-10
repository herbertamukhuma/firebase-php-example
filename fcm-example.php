<?php
/**
 * example borrowed from https://firebase-php.readthedocs.io/en/stable/cloud-messaging.html
*/

use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

require __DIR__.'/vendor/autoload.php';

// Get this from your firebase account at
// https://console.firebase.google.com/project/_/settings/serviceaccounts/adminsdk
$factory = (new Factory)->withServiceAccount('firebase_credentials.json');

$messaging = $factory->createMessaging();

// To be provided by the app
$deviceToken = 'czVTRFeZSlWmkEcyMLBDsH:APA91bEyGH29qQZw3uAx-oRbPfQ6WZ0kzRMF7HVABNjSUc4NKcDvaoQ4bo3CjVeBm4rqaSK9c4wDs1eICSaLOo2_fagO2y5DJMxWsAq8mS68y2DVQMjHFe4aEBYRca8UC0jMKCzitstH';

$notification = Notification::create('Name Test', 'This is a name test');
$data = [
    "id" => 5487, 
    "target" => "client_house",
    "title" => "House View",
    "body" => "Checkout this house",
];

$message = CloudMessage::fromArray([
    'token' => $deviceToken,
    //'notification' => $notification,
    'data' => $data, // optional
])->withHighestPossiblePriority();

try {
    $messaging->send($message);
    print("sent!!!");
} catch (MessagingException $e) {
    print("messaging exception: " . $e->getMessage());
} catch (FirebaseException $e) {
    print("firebase exception: " . $e->getMessage());
}

