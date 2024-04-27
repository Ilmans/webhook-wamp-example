<?php

// all method is for example only, you can modify it as you want.
// if you want simple without manual format,you can use class ResponWebhookFormater.php
class FormatMessage
{
    public static function text($text, $quoted = false)
    {
        return json_encode(['text' => $text, 'quoted' => $quoted]);
    }

    public static function exampleMedia($quoted = false)
    {

        return json_encode([
            'url' => 'https://png.pngtree.com/element_our/md/20180626/md_5b321c99945a2.jpg',
            'type' => 'image', // or 'video', 'document', 'audio'
            'caption' => 'this is media for you {name}',
            'filename' => 'image.jpg', // optional, if you want to change filename, default is 'media.ext'
            'quoted' => $quoted,
        ]);
    }

    public static function exampleButton($quoted = false)
    {
        // button
        $buttons = [
            [
                'buttonId' => 'id1',
                'buttonText' => ['displayText' => 'Button 1'],
                'type' => 1,
            ],
            [
                'buttonId' => 'id2',
                'buttonText' => ['displayText' => 'Button 2'],
                'type' => 1,
            ],
            [
                'buttonId' => 'id3',
                'buttonText' => ['displayText' => 'Button 3'],
                'type' => 1,
            ],
        ];
        $message = [
            'text' => 'text',
            'footer' => 'footer',
            'headerType' => 1,
            'viewOnce' => true,
            'buttons' => $buttons,
            'quoted' => $quoted,
        ];

        // if wnat to add image you can add like this to $message
        // $message['image'] = ['url' => 'url_image']; and change text to caption

        return json_encode($message);
    }

    public static function exampleTemplate($quoted = false)
    {
        $templateButtons = [
            [
                'index' => 1,
                'urlButton' => [
                    'displayText' => 'Visit our website',
                    'url' => 'https://www.example.com',
                ],
            ],
            [
                'index' => 2,
                'callButton' => [
                    'displayText' => 'Call us now',
                    'phoneNumber' => '+1234567890',
                ],
            ],
        ];

        $message = [
            'text' => 'text',
            'footer' => 'footer', // optional
            'templateButtons' => $templateButtons,
            'viewOnce' => true,
            'quoted' => $quoted, // optional
        ];

        // if wnat to add image you can add like this to $message
        // $message['image'] = ['url' => 'url_image']; and change text to caption
        return json_encode($message);
    }

    public static function exampleList($quoted = false)
    {
        $section = [
            'title' => 'Menu List',
            'rows' => [
                [
                    'title' => 'List Item 1',
                    'rowId' => 'id2',
                    'description' => '',
                ],
                [
                    'title' => 'List Item 2',
                    'rowId' => 'id3',
                    'description' => '',
                ],
            ],
        ];

        $section2 = [
            'title' => 'Menu List 2',
            'rows' => [
                [
                    'title' => 'List Item 1',
                    'rowId' => 'id2',
                    'description' => '',
                ],
                [
                    'title' => 'List Item 2',
                    'rowId' => 'id3',
                    'description' => '',
                ],
            ],
        ];

        $listMessage = [
            'text' => 'text',
            'footer' => 'footer',
            'title' => 'name of list',
            'viewOnce' => true,
            'buttonText' => 'button of list',
            'sections' => [$section, $section2],
        ];

        return json_encode($listMessage);
    }
}
