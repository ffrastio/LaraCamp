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


class CheckoutController extends Controller
{
    //
    public function _construct()
    {
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
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
        $orderId = $checkout->id . '-' . Str::random(12);
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
            'item_details' => $item_details,
            'customer_details' => $customer_details
        ];

        try {
            //Get Snap payment URL
            $paymentURL = \Midtrans\Snap::createTransaction($midtrans_params)->redirect_url;
            $checkout->midtrans_url = $paymentURL;
            $checkout->save();

            return $paymentURL;
        } catch (Exception $el) {
            //throw $th;
            return false;
        }
    }
}
