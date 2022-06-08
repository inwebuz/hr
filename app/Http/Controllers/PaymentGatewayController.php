<?php

namespace App\Http\Controllers;

use App\Payment\Click\Application as ClickApplication;
use App\Payment\Click\ClickException;
use App\Payment\Paycom\Application as PaycomApplication;
use App\Payment\Paycom\PaycomException;
use App\Payment\Zoodpay\Application as ZoodpayApplication;
use App\Payment\Zoodpay\ZoodpayException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller
{
    public function paycom(Request $request)
    {
        // Log::info('in payme controller');
        try {
            $paycomConfig = config('services.paycom');
            $application = new PaycomApplication($paycomConfig);
            $application->run();
        } catch (PaycomException $exc) {
            $exc->send();
        }
    }

    public function click(Request $request)
    {
        // Log::info('in click controller');
        try {
            $clickConfig = config('services.click');
            $application = new ClickApplication($clickConfig);
            $application->run();
        } catch (ClickException $e) {
            $e->send();
        }
    }

    public function zoodpay(Request $request)
    {
        // Log::info('in zoodpay controller');
        try {
            $config = config('services.zoodpay');
            $application = new ZoodpayApplication($config);
            return $application->run();
        } catch (ZoodpayException $e) {
            $e->send();
        }
    }
}
