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
        $message['image'] = ['url' => 'https://png.pngtree.com/element_our/md/20180626/md_5b321c99945a2.jpg']; //and change text to caption

        return json_encode($message);
    }



    public static function exampleList($quoted = false, $url = null)
    {

        $section = [
            'list' => [
                [
                    'rows' => [
                        [
                            'title' => 'asdf',
                            'description' => '--',
                        ],
                        [
                            'title' => 'asdf',
                            'description' => '--',
                        ],
                    ],
                    'title' => 'asdf',
                ],
            ],
            'buttonText' => 'asdf',
        ];

        $listMessage = [
            'text' => 'asdfasf',
            'footer' => 'asdf',
            'sections' => [$section],
            'buttonText' => 'asdf',
        ];

        if ($url) {
            $listMessage['image'] = $url;
            $listMessage['caption'] = 'caption';
        }



        return json_encode($listMessage);
    }
}
