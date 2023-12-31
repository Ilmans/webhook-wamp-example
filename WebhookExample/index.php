<?php
require 'formatMessage.php';
// this is simple php webhook for mpwa, not recommended using thi procedural pattern if you have a lot of keywrds!
header('content-type: application/json; charset=utf-8');
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    die('this url is for webhook.');
}
file_put_contents('whatsapp.txt','[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n",FILE_APPEND);                                             
 $message = strtolower($data['message']);
 $from = strtolower($data['from']);
 $bufferimage = isset($data['bufferImage']) ? $data['bufferImage'] : null;
 $respon = false;

// for text message
if ($message == 'hi') {
    $respon = FormatMessage::text('Hello, how are you?',true);
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
if ($message == 'template') {
    $respon = FormatMessage::exampleTemplate(true);
}

// for list message
if ($message == 'list') {
    $respon = FormatMessage::exampleList(true);
}

// get image
if ($bufferimage) {
    $base64str = 'data:image/png;base64,' . $bufferimage;
    list(,$base64str) = explode(';', $base64str);
    list(,$base64str) = explode(',', $base64str);
    $imagedata = base64_decode($base64str);
    $filename = 'images/' . time() . '.png';
   $file = file_put_contents($filename, $imagedata);
    fwrite($file, $imagedata);
    fclose($file);
}


echo $respon;

?>
