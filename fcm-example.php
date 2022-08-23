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
$deviceToken = '..';

$notification = Notification::create('Name Test', 'This is a name test');
$data = ["name" => "herbert"];

$message = CloudMessage::withTarget('token', $deviceToken)
    ->withNotification($notification) // optional
    ->withData($data) // optional
;

$message = CloudMessage::fromArray([
    'token' => $deviceToken,
    'notification' => $notification,
    'data' => $data, // optional
]);

try {
    $messaging->send($message);
    print("sent!!!");
} catch (MessagingException $e) {
    print("messaging exception: " . $e->getMessage());
} catch (FirebaseException $e) {
    print("firebase exception: " . $e->getMessage());
}

