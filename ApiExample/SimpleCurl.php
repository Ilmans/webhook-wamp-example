<?php


// 
$postData = [
  'api_key' => $this->apikey,
  'sender' => $this->sender,
  'number' => $this->to,
  'message' => join("\n", $this->lines),

];

$ch = curl_init($this->url . $route);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);


$response = curl_exec($ch);
curl_close($ch);
var_dump($response);
