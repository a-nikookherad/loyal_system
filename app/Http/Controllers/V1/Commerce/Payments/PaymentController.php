<?php

namespace App\Http\Controllers\V1\Commerce\Payments;

use App\Http\Controllers\Controller;
use App\Logics\SamanPay;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\ReserveLog;
use App\Repositories\PaymentDB\PaymentReadRepo;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        try {
            $filter = [];
            $paymentsReadRepo = new PaymentReadRepo();
            $paymentsList = $paymentsReadRepo->all($filter);
            return $this->successResponse("messages.success_response", $paymentsList);
        } catch (\Exception $exception) {
            return $this->errorResponse("messages.error_response", [$exception->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $paymentsReadRepo = new PaymentReadRepo();
            $paymentInstance = $paymentsReadRepo->find($id);
            return $this->successResponse("messages.success_response", $paymentInstance);
        } catch (\Exception $exception) {
            return $this->errorResponse("messages.error_response", [$exception->getMessage()]);
        }
    }

    public function createOrder($data, $payment, $attachment)
    {
        //1. create order

        //2. check has a payment

        //3. check has an attachments

    }

    public function verifyByAccountant()
    {

    }

    public function hiddenForm()
    {
        try {
            $payment_id = \request()->has("payment_id") ? request("payment_id") : null;
            if (empty($payment_id)) {
                return redirect()->back()->with("error", "پرداخت با مشکل مواجه شد در صورت کسر از حساب مبلغ پرداختی طی ۷۲ ساعت آتی به حساب شما باز خواهد گشت");
            }

            $paymentInstance = Payment::query()
                ->find($payment_id);

//            $redirectURL = 'https://hamimohajer.com/payment/verify';
            $redirectURL = route("payment.verify");

            $samanInstance = new SamanPay();
            $token = $samanInstance->getToken($paymentInstance->amount, $paymentInstance->ResNum, $paymentInstance->user->mobile ?? "09375727006", $redirectURL);

            if ($token) {
                // save token to database
                $paymentInstance->token = $token;
                $paymentInstance->save();
            } else {
                // error actions....
                return redirect()->back()->with("error", "پرداخت با مشکل مواجه شد در صورت کسر از حساب مبلغ پرداختی طی ۷۲ ساعت آتی به حساب شما باز خواهد گشت");
            }

            //success action & redirect to bank
            return view("payment.redirect_to_bank", [
                "amount" => $paymentInstance->amount,
                "token" => $token,
                "redirectURL" => $redirectURL,
                "merchant_id" => $paymentInstance->merchant_id,
                "cellNumber" => $paymentInstance->user->mobile ?? "09375727006"
            ]);

        } catch (\Exception $exception) {
            return redirect()->back()->with("error", "something went wrong" ?? $exception->getFile() . $exception->getMessage() . $exception->getLine());
        }
    }

    public function verify(Request $request)
    {
        //check bank return state
        if (!$request->has("State") || $request->State != "OK") {
            return redirect()->route("home")->with("error", "پرداخت با مشکل مواجه شد در صورت کسر از حساب مبلغ پرداختی طی ۷۲ ساعت آتی به حساب شما باز خواهد گشت");
        }

        // validate input
        if (!$request->has("Token")) {
            return redirect()->route("home")->with("error", "پرداخت با مشکل مواجه شد در صورت کسر از حساب مبلغ پرداختی طی ۷۲ ساعت آتی به حساب شما باز خواهد گشت");
        }

        // check user payments records
        $paymentInstance = Payment::query()
            ->with("customer")
            ->where("token", $request->Token)
            ->first();

        // check user payments records
        $paymentDuplicateCheck = Payment::query()
            ->where("RefNum", $request->RefNum)
            ->first();
        if ($paymentDuplicateCheck instanceof Payment) {
            return redirect()->route("home")->with("error", "پرداخت انجام نمی شود!");
        }

        //verify transaction
        $samanInstance = new SamanPay();
        $verifyTransactionAmount = $samanInstance->verifyTransaction($request->RefNum, $request->TerminalId);

        //check verification
        if ($verifyTransactionAmount != $paymentInstance->amount) {
            return redirect()->route("home")->with("error", "پرداخت با مشکل مواجه شد در صورت کسر از حساب مبلغ پرداختی طی ۷۲ ساعت آتی به حساب شما باز خواهد گشت");
        }
        /*        $request->all = [
                    "MID" => "0",
                    "TerminalId" => "12096014",
                    "RefNum" => "GmshtyjwKSvD7kiuu3XcWjlZI4Kthl8d4xS/RPK9Dv",
                    "ResNum" => "lottery_604ef9ca0a75f",
                    "State" => "OK",
                    "TraceNo" => "304480",
                    "Amount" => "10000",
                    "AffectiveAmount" => "10000",
                    "Wage" => null,
                    "Rrn" => "18306467795",
                    "SecurePan" => "504172******0042",
                    "Status" => "2",
                    "Token" => "d0da09c40e5941cab50424ebb6904100",
                    "HashedCardNumber" => "FCD730725105588CC64D1DCFE482EFAAFDF713CEEE38AD29CBC398ED16C57C0D",
                ];*/
        // Transaction Successful
        $paymentInstance->paid_at = now();
        $paymentInstance->MID = $request->MID;
        $paymentInstance->terminal_id = $request->TerminalId;
        $paymentInstance->RefNum = $request->RefNum;
        $paymentInstance->ResNum = $request->ResNum;
        $paymentInstance->State = $request->State;
        $paymentInstance->TRACENO = $request->TraceNo;
        $paymentInstance->AffectiveAmount = $request->AffectiveAmount;
        $paymentInstance->Wage = $request->Wage;
        $paymentInstance->Rrn = $request->Rrn;
        $paymentInstance->SecurePan = $request->SecurePan;
        $paymentInstance->Status = $request->Status;
        $paymentInstance->CID = $request->CID;
        $paymentInstance->HashedCardNumber = $request->HashedCardNumber;
        $paymentInstance->StateCode = $request->StateCode;
        $paymentInstance->save();

        //listener for reservation payment
        //increment reservation log time
        if ($paymentInstance->paymentable_type == "Reservation") {
            $reservationInstance = Reservation::query()
                ->where("id", $paymentInstance->paymentable_id)
                ->first();

            $reservationLogInstance = ReserveLog::query()
                ->where("date", $reservationInstance->present_date)
                ->where("time", $reservationInstance->present_time)
                ->firstOrCreate();
            $reservationLogInstance->number = $reservationLogInstance->number + 1;
            $reservationLogInstance->save();
        }

        if ($paymentInstance->paymentable_type == "InquiryLottery") {
            //send sms for submit from successfully
            \App\Jobs\SendSmsJob::dispatch($paymentInstance->customer->mobile, "حامی مهاجر
اطلاعات شما دریافت شد. به محض اعلام رسمی نتایج توسط مرکز کنسولی کنتاکی، از طریق پیامک نتیجه را دریافت خواهید کرد.
https://hamimohajer.com")
                ->onQueue("sms");
        } elseif ($paymentInstance->paymentable_type == "Lottery") {
            \App\Jobs\SendSmsJob::dispatch($paymentInstance->customer->mobile, "حامی مهاجر
ثبت نام شما در سایت حامی مهاجر با موفقیت انجام شد. موارد مربوط به این پرونده، از همین طریق اطلاع رسانی خواهد شد.
Hamimohajer.com")
                ->onQueue("sms");
        }

        $paymentInstance = $paymentInstance->load("customer");
        //return success response for payment
        return view("payment.success", compact("paymentInstance"))->with("success", "payment successfully");
    }
}
