<?php


namespace App\Logics;


use App\Http\Requests\ApprovePaymentRequest;
use App\Models\Payment;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PaymentLogic
{
    private $secretKey;
    private $linkUrl;

    public function __construct()
    {
//        $this->secretKey = env('APP_KEY', 'S3Kr3t');
        $this->secretKey = 'S3Kr3t';
//        $this->linkUrl = env("APP_URL", "https://hamimohajer.com") . "/payment_preview";
        $this->linkUrl = env("APP_URL", "https://hamimohajer.com") . "/payment_preview";
    }

    /**
     * @param $payment_id
     * @param $text
     * @param null $exp
     * @return string
     * @throws Throwable
     */
    public function generateSmsBody($payment_id, $text, $exp = null): string
    {
        # todo: uncomment if the process of handling payment is based on JWT
//        $payload = ['payment_id' => $payment_id, 'exp' => $exp];
        $link = $this->generateLink($payment_id, $exp);
        return $text . " " . $link;
    }


    /**
     * @param $token
     * @return Builder|Model|object|null
     */
    public function getPaymentInstanceFromToken($token)
    {
//        ['payment_id' => $payment_id] = $this->decodeToken($token);
//        dd($token);
        $decoded = $this->decodeToken($token);
//        dd($decoded);
        return Payment::query()
            ->where("id", $decoded['payment_id'])
            ->first();
    }

    /**
     * @param $payload
     * @param null $exp
     * @return string
     */
    private function generateLink($payload, $exp = null): string
    {
        try {

//            if ($exp) {
//                $payload['exp'] = $exp;
//            }
//            dd($payload);
//            $exp && $payload['exp'] = $exp;
//            $token = JWT::encode($payload, $this->secretKey);
//            dd($token);
            return "$this->linkUrl/$payload";
        } catch (Throwable $th) {
            return $th;
        }

    }

    /**
     * @param $token
     * @return Exception|Throwable
     */
    private function decodeToken($token)
    {
        try {
//            dd($token);
//            dd(JWT::decode($token, $this->secretKey));
//            dd(JWT::decode($token, $this->secretKey, array('HS256')));
//dd(gettype($token));
//            dd($token);
            $res = JWT::decode($token, $this->secretKey, ['HS256']);
            dd((array)$res);
            return $res;
        } catch (Throwable $th) {
            dd($th->getMessage());
            return $th;
        }
    }


    public function approve_payment_by_financial($request):Model
    {
        //get payment
        $paymentInstance = Payment::query()
            ->where("id", $request->payment_id)
            ->first();

        //update payment
        $paymentInstance->paid_at = now()->format("Y-m-d H:i:s");
        $paymentInstance->currency = $request->currency ?? "rials";
        $paymentInstance->payment_type = "accountant";
        $paymentInstance->author_id = Auth::id();
        $paymentInstance->description = $request->description ?? null;
        $paymentInstance->save();

        //get attachment file
        if ($request->hasFile("attachment")) {
            save_attachment($request->file("attachment"), $paymentInstance, "financial", ["title" => $request->title]);
        }

        //return payment instance
        return $paymentInstance;
    }
}
