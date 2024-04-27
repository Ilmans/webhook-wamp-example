<?php

class ResponWebhookFormater
{

    protected $lines;
    protected $footer;
    protected $quoted = false;
    protected $buttons = [];
    protected $templates = [];
    protected $sectionsList = [];
    protected $image = null;


    /**
     * @param string $text
     * to add new line to your whatssapp respon message
     */
    public function line($text = '')
    {
        $this->lines[] = $text;
        return $this;
    }

    /**
     * @param string $text
     * to bold your whatssapp respon message
     */
    public function bold($text = '')
    {
        $this->lines[] = '*' . $text . '*';
        return $this;
    }

    /**
     * @param string $text
     * to italic your whatssapp respon message
     */
    public function italic($text = '')
    {
        $this->lines[] = '_' . $text . '_';
        return $this;
    }

    /**
     * to quote your whatssapp respon message
     */
    public function quoted()
    {
        $this->quoted = true;
        return $this;
    }

    /**
     * @param string $url
     * to add image to your whatssapp respon message
     */
    public function image($url = null)
    {
        $this->image = ['url' => $url];
        return $this;
    }

    /**
     * @param string $text button
     * to add button to your message, maximal using this function 3 times
     */
    public function addButton($text)
    {
        $indexbutton = count($this->buttons) + 1;
        $this->buttons[] = ['buttonId' => 'id'  . $indexbutton, 'buttonText' => ['displayText' => $text], 'type' => 1];
        return $this;
    }

    /**
     * @param string $name name template button
     * @param string $value value when button clicked
     * @param string $type type of button, url or call
     */
    public function addTemplateButton($name, $value, $type = 'url')
    {
        $type = $type !== 'url' ? 'call' : 'url';
        $indexbutton = count($this->templates) + 1;
        $this->templates[] = [
            'index' => $indexbutton,
            $type . 'Button' => [
                'displayText' => $name,
                $type == 'url' ? 'url' : 'phoneNumber' => $value,
            ],
        ];
        return $this;
    }

    /**
     * @param string $title title list
     * @param array $rows array of list
     * to add list to your message, maximal using this function 3 times
     */
    public function addSection($title, $rows)
    {
        $this->sectionsList[] = [
            'title' => $title,
            'rows' => $rows,
        ];
        return $this;
    }


    /**
     * private function to convert line to message
     */
    private function convertLines()
    {
        $text = '';
        foreach ($this->lines as $line) {
            $text .= $line . "\n";
        }
        return $text;
    }


    /**
     * @param string $footer
     * to set footer to your message, only support in button,list and template message
     */
    public function footer($footer = '')
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * apply respons Text
     */
    public function responAsText()
    {
        return json_encode([
            'text' => $this->convertLines(), 'quoted' => $this->quoted,
        ]);
    }

    /**
     * @param string $url
     * apply respons as image
     */
    public function responAsMedia($url = '', $type = 'image', $filename = null)
    {
        return json_encode([
            'type' => $type, //image,video,document or audio
            'url' => $url,
            'filename' => $filename, //optional
            'caption' => $this->convertLines(),
        ]);
    }

    /**
     * apply respons as button
     */
    public function responAsButton()
    {
        $message = [
            'footer' => $this->footer,
            'headerType' => 1,
            'viewOnce' => true,
            'buttons' => $this->buttons,
            'quoted' => $this->quoted,
        ];
        if ($this->image) {
            $message['image'] = ['url' => $this->image['url']];
            $message['caption'] = $this->convertLines();
        } else {
            $message['text'] = $this->convertLines();
        }
        return json_encode($message);
    }

    /**
     * apply respons as template button
     */
    public function responAsTemplateButton()
    {
        $message = [
            'footer' => $this->footer,
            'templateButtons' => $this->templates,
            'viewOnce' => true,
            'quoted' => $this->quoted,
        ];
        if ($this->image) {
            $message['image'] = ['url' => $this->image['url']];
            $message['caption'] = $this->convertLines();
        } else {
            $message['text'] = $this->convertLines();
        }
        return json_encode($message);
    }


    public function responAsList($title = "List", $nameButton = "Show List")
    {
        $listMessage = [
            'text' => $this->convertLines(),
            'footer' => $this->footer,
            'title' => $title,

            'buttonText' => $nameButton,
            'sections' => $this->sectionsList,
        ];

        return json_encode($listMessage);
    }


    /**
     * Apply response as audio
     * @param string $url
     * @param bool $ptt
     * @return string
     */
    public function responAsAudio($url = '', $ptt = true)
    {
        $message = [
            'audio' => ['url' => $url],
            'ptt' => $ptt,
            'mimetype' => 'audio/mpeg',
            'caption' => $this->convertLines(),
        ];
        return json_encode($message);
    }
}
