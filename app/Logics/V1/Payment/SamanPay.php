<?php


namespace App\Logics;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Integer;

class SamanPay
{
    private $paymentInformation;
    private $bankSettings;

    public function __construct()
    {
        $this->bankSettings["merchant_id"] = env("MERCHANT_ID", "12096014");
        $this->bankSettings["tokenUrl"] = env("BANK_TOKEN_URL", "https://sep.shaparak.ir/onlinepg/onlinepg");
        $this->bankSettings["verifyTransactionUrl"] = env("BANK_VERIFY_TRANSACTION_URL", "https://sep.shaparak.ir/verifyTxnRandomSessionkey/ipg/VerifyTransaction");
    }

    /**
     * for receive token from bank (step 1)
     * @param int $amount
     * @param string $resNumber
     * @param string $mobile
     * @param string $redirectURL
     * @return string
     */
    public function getToken(int $amount, string $resNumber, string $mobile, string $redirectURL): string
    {
        try {
            $data = [
                "TerminalId" => $this->bankSettings["merchant_id"],
                "Resnum" => $resNumber,
                "Amount" => $amount,
                "Action" => "Token",
                "CellNumber" => $mobile,
                "RedirectURL" => $redirectURL,
            ];
            $header = [
                "Content-type" => "application/json",
                "Accept" => "application/json",
                'verify' => false
            ];
/*            $option = [
                'verify' => false
            ];*/
            $restClient = Http::withHeaders($header)
//                ->withOptions($option)
                ->post($this->bankSettings["tokenUrl"], $data);
        } catch (\Exception $exception) {
            return $exception->getMessage();
//            dd($exception->getMessage(),$exception->getFile(),$exception->getLine());
        }

        return $restClient->json("token");
    }

    public function verifyTransaction(string $refNumber, string $terminalId): int
    {
        $data = [
            "RefNum" => $refNumber,
            "TerminalNumber" => $terminalId,
            "NationalCode" => "null",
            "IgnoreNationalcode" => true,
        ];
        $header = [
            "Content-type" => "application/json",
            "Accept" => "application/json"
        ];
        $totalAmount = Http::withHeaders($header)->post($this->bankSettings["verifyTransactionUrl"], $data);
        $transactionDetails = $totalAmount->json("TransactionDetail");
        /*        $transactionDetails =[
                    "RRN" => "18306467795",
                    "RefNum" => "GmshtyjwKSvD7kiuu3XcWjlZI4Kthl8d4xS/RPK9Dv",
                    "MaskedPan" => "504172****0042",
                    "HashedPan" => "fcd730725105588cc64d1dcfe482efaafdf713ceee38ad29cbc398ed16c57c0d",
                    "TerminalNumber" => 12096014,
                    "OrginalAmount" => 10000,
                    "AffectiveAmount" => 10000,
                    "StraceDate" => "2021-03-15 09:39:17",
                    "StraceNo" => "304480",
                ]*/
        return $transactionDetails["OrginalAmount"];
    }

}
