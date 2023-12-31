<?php


class WampService
{
    protected string $to;
    protected array $lines = [];
    protected string $apikey;
    protected string $url;
    protected string $sender;
    protected $media = null;
    protected string $mediaType;

    public function __construct($lines = [])
    {
        $this->lines = $lines;
        $this->apikey = getenv('WAMP_API_KEY');
        $this->url = getenv('WAMP_URL');
        $this->sender = getenv('WAMP_SENDER');
    }

    public function media($media): self
    {
        $this->media = $media;
        return $this;
    }

    public function mediaType($mediaType): self
    {
        $this->mediaType = $mediaType;
        return $this;
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;
        return $this;
    }

    public function formatText($text, $format): self
    {
        $formattedText = " {$format}{$text}{$format}";
        if (!empty($this->lines)) {
            $this->lines[count($this->lines) - 1] .= $formattedText;
        } else {
            $this->lines[] = $formattedText;
        }
        return $this;
    }

    public function bold($text): self
    {
        return $this->formatText($text, '*');
    }

    public function italic($text): self
    {
        return $this->formatText($text, '_');
    }

    public function code($text): self
    {
        return $this->formatText($text, '`');
    }

    public function separator(): self
    {
        $this->lines[] = str_repeat('-', 35);
        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;
        return $this;
    }

    public function send()
    {
        if (!$this->to || !count($this->lines)) {
            return false;
        }

        $route = $this->media ? '/send-media' : '/send-message';
        $postData = [
            'api_key' => $this->apikey,
            'sender' => $this->sender,
            'number' => $this->to,
            'message' => join("\n", $this->lines),
            'url' => $this->media,
            'media_type' => $this->mediaType,
            'caption' => join("\n", $this->lines),
        ];

        $ch = curl_init($this->url . $route);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        try {
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
