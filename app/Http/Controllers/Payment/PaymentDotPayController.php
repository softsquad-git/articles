<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Evilnet\Dotpay\DotpayManager;
use Illuminate\Http\Request;

class PaymentDotPayController extends Controller
{
    private $dotpayManager;

    public function __construct(DotpayManager $dotpayManager)
    {
        $this->dotpayManager = $dotpayManager;
    }

    public function callback(Request $request)
    {
        $response = $this->dotpayManager->callback($request->all());
        return response('ok');
    }

    public function pay()
    {
        $data = [
            'amount' => '100',
            'currency' => 'PLN',
            'description' => 'Payment for internal_id order',
            'control' => '12345', //ID that dotpay will pong you in the answer
            'language' => 'pl',
            'ch_lock' => '1',
            'url' => config('dotpay.options.url'),
            'urlc' => config('dotpay.options.curl'),
            'expiration_datetime' => '2021-12-01T16:48:00',
            'payer' => [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'email' => 'john.smith@example.com',
                'phone' => '+48123123123'
            ],
            'recipient' => config('dotpay.options.recipient')

        ];

        return redirect()->to($this->dotpayManager->createPayment($data));
    }
}
