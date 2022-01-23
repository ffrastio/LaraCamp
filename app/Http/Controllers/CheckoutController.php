<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\Checkout\Store;
use App\Models\Camps;
use App\Models\Checkout;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Midtrans;
use Midtrans\Notification;



class CheckoutController extends Controller
{
    //
    public function __construct()
    {
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
        Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function index(Request $request, Camps $camp)
    {
        if ($camp->isRegistered) {
            $request->session()->flash('error', "You already registered on {$camp->title} camp.");
            return redirect()->route('user.dashboard');
        }
        return view('checkout', [
            'camp' => $camp
        ]);
    }

    public function store(Store $request, Camps $camp)
    {
        $data = $request->all();

        $data['users_id'] = Auth::id();
        $data['camps_id'] = $camp->id;

        //mengambil data user

        $user = Auth::user();
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->occupation = $data['occupation'];
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->save();

        //create checkout
        $checkout = Checkout::create($data);
        $this->getSnapRedirect($checkout);
        return redirect()->route('checkout.success');
    }

    public function success(Request $request)
    {
        return view('success');
    }

    public function getSnapRedirect(Checkout $checkout)
    {
        $orderId = $checkout->id . '-' . Str::random(10);
        $price = $checkout->Camp->price * 1000;
        $checkout->midtrans_booking_code = $orderId;
        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $price,
        ];

        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantity' => 1,
            'name' => "Payment for {$checkout->Camp->title} camp"
        ];

        $userData = [
            "first_name" => $checkout->User->name,
            "last_name" => "",
            "email" => $checkout->User->email,
            "phone" => $checkout->User->phone,
            "address" => $checkout->User->address,
            "city" => "",
            "postal_code" => "",
            "country_code" => "IDN"
        ];

        $customer_details = [
            "first_name" => $checkout->User->name,
            "last_name" => "",
            "email" => $checkout->User->email,
            "phone" => $checkout->User->phone,
            "billing_address" => $userData,
            "shipping_address" => $userData
        ];

        $midtrans_params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        ];

        try {
            //Get Snap payment URL
            $paymentURL = \Midtrans\Snap::createTransaction($midtrans_params)->redirect_url;
            $checkout->midtrans_url = $paymentURL;
            $checkout->save();

            return $paymentURL;
        } catch (Exception $e) {
            //throw $th;
            return false;
        }
    }

    public function midtransCallBack(Request $request)
    {
        $notif = $request->method() == 'POST' ? new Notification() : Midtrans\Transaction::status($request->order_id);

        $status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        $checkout_id = explode('-', $notif->order_id)[0];
        $checkout = Checkout::findOrFail($checkout_id);

        if ($status == 'capture') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'challenge'
                $checkout->payment_status = 'pending';
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'success'
                $checkout->payment_status = 'paid';
            }
        } else if ($status == 'cancel') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status = 'failed';
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status = 'failed';
            }
        } else if ($status == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
            $checkout->payment_status = 'failed';
        } else if ($status == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $checkout->payment_status = 'paid';
        } else if ($status == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $checkout->payment_status = 'pending';
        } else if ($status == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $checkout->payment_status = 'failed';
        }

        // return dd($checkout);
        $checkout->save();
        return view('success');
    }
}
