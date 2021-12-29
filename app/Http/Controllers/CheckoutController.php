<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use Illuminate\Http\Request;

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
        return $camp;
        return $request->all();
    }

    public function success(Request $request)
    {
        return view('success');
    }
}
