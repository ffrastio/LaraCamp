<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index(){
        $checkouts = Checkout::with(['Camp'])->whereUsersId(Auth::id())->get();

        return view('auth.user.dashboard', [
            'checkouts' => $checkouts
        ]);
    }
}
