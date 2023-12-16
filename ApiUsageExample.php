<?php


$wampService = new WampService();

//example send text
$wampService->line('Hello, this is a regular line of text.')
    ->bold('This line of text is bold.')
    ->italic('This line of text is italic.')
    ->code('This line of text is code.')
    ->separator()->to('xxxx')->send();
// example send media image
$wampService->media('http://example.com/path/to/image.jpg')
    ->mediaType('image')->to('xxxx')->send();

// example send pdf
$wampService->media('http://example.com/path/to/document.pdf')
    ->mediaType('document')->to('xxxx')->send();

// example send media video
$wampService->media('http://example.com/path/to/video.mp4')
    ->mediaType('video')->to('xxxx')->send();

