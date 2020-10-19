<?php


namespace App\Libraries;


use Illuminate\Support\Facades\Http;

class SMS
{

    protected array $headers;
    protected array $smsBody;
    private string $url;

    public function __construct()
    {
        $this->url = env('SMS_URL');
    }

    public function setUp($body = [] ,$headers = []):self
    {
        $this->smsBody = $body;
        $this->headers = $headers;
        return $this;
    }

    public function send():void
    {
        Http::withHeaders($this->headers)
            ->get($this->url,$this->smsBody);
    }

}
