<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Service\Payment\PaymentResponseService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct(private PaymentResponseService $paymentResponseService){}

    public function index(Request $request)
    {

            $data = $request->all();

            $alldata = $request->all();

            if(!isset($data['reference'])) {
                return redirect()->route('payment.failed');
                exit;
            }

            ksort($data);

            $hmac = $data['hmac'];

            $array = [
                'amount_cents',
                'created_at',
                'currency',
                'error_occured',
                'has_parent_transaction',
                'id',
                'integration_id',
                'is_3d_secure',
                'is_auth',
                'is_capture',
                'is_refunded',
                'is_standalone_payment',
                'is_voided',
                'order',
                'owner',
                'pending',
                'source_data_pan',
                'source_data_sub_type',
                'source_data_type',
                'success',
            ];

            $connectedString = '';

            foreach ($data as $key => $element) {

                if(in_array($key, $array)) {
                    $connectedString .= $element;
                }
            }

            $secret = env('PAYMOB_HMAC');

            $hased = hash_hmac('sha512', $connectedString, $secret);

            // $hased == $hmac &&

          if( $alldata['success'] == 'true') {

                return $this->paymentResponseService->response($alldata['reference'], $alldata, $alldata['id']);
            }

            return redirect()->route('payment.failed');
    }


}
