<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    //
    public function index(Request $request, Camps $camp)
    {
        return view('checkout', [
            'camp' => $camp
        ]);
    }

    public function store(Request $request, Camps $camp)
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
        return redirect()->route('checkout.success');
    }

    public function success(Request $request)
    {
        return view('success');
    }
}
