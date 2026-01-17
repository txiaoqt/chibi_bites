<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        // Show user-specific orders if authenticated, otherwise show guest orders from session
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $orders = $user->orders()->with('orderItems.product')->latest()->get();
        } else {
            $orderIds = session()->get('order_ids', []);
            $orders = Order::with('orderItems.product')->whereIn('id', $orderIds)->get();
        }

        return view('account', compact('orders'));
    }
}
