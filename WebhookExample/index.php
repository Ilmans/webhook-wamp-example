<?php
require 'ExampleManualMessage.php';
// this is simple php webhook for mpwa, not recommended using thi procedural pattern if you have a lot of keywrds!
header('content-type: application/json; charset=utf-8');
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    die('this url is for webhook.');
}
file_put_contents('whatsapp.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);
$message = strtolower($data['message']);
$from = strtolower($data['from']);
$media = isset($data['media']);
$respon = false;

// for text message
if ($message == 'hi') {
    $respon = FormatMessage::text('Hello, how are you {name}?', true);
}
// 
// for media message
if ($message == 'media') {
    $respon = FormatMessage::exampleMedia(true);
}

// for button message
if ($message == 'button') {
    $respon = FormatMessage::exampleButton(true);
}

// for template message


// for list message
if ($message == 'list') {
    $respon = FormatMessage::exampleList(true);
}

// get image
if ($media && $media !== null) {
    $media = $data['media'];
    $streamData = $media['stream']['data'];
    $binaryData = pack('C*', ...$streamData);
    $fileName = $media['fileName'];
    $tempPath = 'images/' . $fileName;
    file_put_contents($tempPath, $binaryData);
}


echo $respon;
