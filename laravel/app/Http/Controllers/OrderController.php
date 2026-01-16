<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = [];
        $total = 0;

        if (Auth::check()) {
            // For authenticated users, get cart from database
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $userCartItems = $user->cartItems()->with('product')->get();

            if ($userCartItems->isEmpty()) {
                return redirect()->route('cart.index');
            }

            foreach ($userCartItems as $cartItem) {
                if ($cartItem->product) {
                    $subtotal = $cartItem->product->price * $cartItem->quantity;
                    $cartItems[] = [
                        'product' => $cartItem->product,
                        'quantity' => $cartItem->quantity,
                        'subtotal' => $subtotal,
                    ];
                    $total += $subtotal;
                }
            }
        } else {
            // For guests, get cart from session
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return redirect()->route('cart.index');
            }

            foreach ($cart as $id => $quantity) {
                $product = Product::find($id);
                if ($product) {
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $product->price * $quantity,
                    ];
                    $total += $product->price * $quantity;
                }
            }
        }

        return view('checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        // Require authentication to place orders
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to place an order.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'delivery_address' => 'required|string',
            'delivery_option' => 'required|in:pickup,delivery',
        ]);

        // Get cart items based on authentication status
        $cartItems = [];
        $total = 0;

        if (Auth::check()) {
            // For authenticated users, get cart from database
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $cartItems = $user->cartItems()->with('product')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index');
            }

            foreach ($cartItems as $cartItem) {
                if ($cartItem->product) {
                    $total += $cartItem->product->price * $cartItem->quantity;
                }
            }
        } else {
            // For guests, get cart from session
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return redirect()->route('cart.index');
            }

            foreach ($cart as $id => $quantity) {
                $product = Product::find($id);
                if ($product) {
                    $cartItems[$id] = ['product' => $product, 'quantity' => $quantity];
                    $total += $product->price * $quantity;
                }
            }
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
            'delivery_address' => $request->delivery_address,
            'delivery_option' => $request->delivery_option,
            'phone' => $request->phone,
            'email' => $request->email,
            'name' => $request->name,
        ]);

        // Create order items based on cart type
        if (Auth::check()) {
            // For authenticated users, use database cart items
            foreach ($cartItems as $cartItem) {
                if ($cartItem->product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->product->price,
                    ]);
                }
            }
        } else {
            // For guests, use session cart items
            foreach ($cartItems as $productId => $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['product']->price,
                ]);
            }
        }

        // Clear cart after order placement
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->cartItems()->delete(); // Clear database cart for authenticated users
        } else {
            session()->forget('cart'); // Clear session cart for guests
        }

        // Store order id in session for account history (for guest users)
        if (!Auth::check()) {
            $orderIds = session()->get('order_ids', []);
            $orderIds[] = $order->id;
            session()->put('order_ids', $orderIds);
        }

        return redirect()->route('order.confirmation', $order->id);
    }

    public function confirmation($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('order-confirmation', compact('order'));
    }
}
