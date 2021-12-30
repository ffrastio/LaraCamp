<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('home');
    }

    public function dashboard(Request $request)
    {
        $checkouts = Checkout::with(['Camp'])->whereUsersId(Auth::id())->get();

        return view('auth.user.dashboard', [
            'checkouts' => $checkouts
        ]);
    }
}
