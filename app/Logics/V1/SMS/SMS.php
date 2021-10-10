<?php


namespace App\Logics;

use Illuminate\Support\Facades\Http;
use Throwable;

class SMS
{
    private $url;
    private $username;
    private $password;
    private $fromNumber;

    public function __construct()
    {
        $this->url = env("SMS_URL", "http://rest.payamak-panel.com/api/SendSMS/SendSMS");
        $this->username = env("SMS_USERNAME", "cyber2");
        $this->password = env("SMS_PASSWORD", "3f79hdm");
        $this->fromNumber = env("SMS_Number", "30007290000575");
    }

    public function sendSms($mobile, $text)
    {
        try {
            $response = $this->sender($mobile, $text);
            if (!$response->successful()) {
                throw new \Exception("some thing went wrong");
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @throws Throwable
     */
    public function sendPaymentSms($mobile, $text) {
        try {
            $response = $this->sender($mobile, $text);
            if (!$response->successful()) {
                throw new \Exception("some thing went wrong");
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param $mobile
     * @param $text
     * @return \Illuminate\Http\Client\Response
     */
    private function sender($mobile, $text) {
        return Http::post($this->url, [
            'username' => $this->username,
            'password' => $this->password,
            'to' => $mobile,
            'from' => $this->fromNumber,
            'text' => $text,
            'isflash' => 'false'
        ]);
    }
}
