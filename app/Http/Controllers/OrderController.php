<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


    public function checkoutSelected(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:products,id',
        ]);

        $selectedProductIds = $request->selected_items;

        // Get authenticated user's cart items that match selected products
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $selectedCartItems = $user->cartItems()
            ->with('product')
            ->whereIn('product_id', $selectedProductIds)
            ->get();

        if ($selectedCartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'No valid items selected for checkout.');
        }

        // Store selected items in session for checkout
        $checkoutItems = [];
        $total = 0;

        foreach ($selectedCartItems as $cartItem) {
            if ($cartItem->product) {
                $checkoutItems[] = [
                    'product' => $cartItem->product,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                ];
                $total += $cartItem->product->price * $cartItem->quantity;
            }
        }

        // Store in session
        session()->put('checkout_selected_items', $checkoutItems);
        session()->put('checkout_total', $total);

        return redirect()->route('checkout');
    }

    public function checkout(Request $request)
    {
        $cartItems = [];
        $total = 0;

        // Check if there are selected items from cart
        $selectedItems = session()->get('checkout_selected_items');
        $selectedTotal = session()->get('checkout_total');

        if ($selectedItems && $selectedTotal) {
            // Handle selected items from cart
            $cartItems = $selectedItems;
            $total = $selectedTotal;
        } elseif (Auth::check()) {
            // For authenticated users, get full cart from database
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

        // Check if this is a selected items checkout
        $selectedItems = session()->get('checkout_selected_items');
        $selectedTotal = session()->get('checkout_total');

        $cartItems = [];
        $total = 0;
        $isSelectedCheckout = false;

        if ($selectedItems && $selectedTotal) {
            // Handle selected items checkout
            $cartItems = $selectedItems;
            $total = $selectedTotal;
            $isSelectedCheckout = true;

            // Clear selected items session data
            session()->forget(['checkout_selected_items', 'checkout_total']);
        } else {
            // Handle regular cart checkout
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

        // Create order items
        foreach ($cartItems as $cartItem) {
            // Handle different cart item formats (selected checkout vs regular cart)
            if (is_array($cartItem)) {
                // Selected checkout items (stored as arrays in session)
                $productId = $cartItem['product']->id;
                $quantity = $cartItem['quantity'];
                $price = $cartItem['product']->price;
            } else {
                // Regular cart items (Eloquent models)
                $productId = $cartItem->product_id;
                $quantity = $cartItem->quantity;
                $price = $cartItem->product->price;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        // Clear cart after order placement
        if ($isSelectedCheckout) {
            // For selected checkout, remove only the selected items from cart
            if (Auth::check()) {
                /** @var \App\Models\User $user */
                $user = Auth::user();
                // Get product IDs from the cart items that were checked out
                $checkedOutProductIds = collect($cartItems)->map(function($item) {
                    return is_array($item) ? $item['product']->id : $item->product_id;
                })->toArray();
                $user->cartItems()->whereIn('product_id', $checkedOutProductIds)->delete();
            }
        } elseif (Auth::check()) {
            // For regular full cart checkout, clear all cart items
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->cartItems()->delete();
        } else {
            // For guest regular checkout, clear session cart
            session()->forget('cart');
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

    public function track($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        // Calculate order status based on time elapsed since order was placed (local delivery)
        $orderDate = $order->created_at;
        $now = now();
        $hoursElapsed = $orderDate->diffInHours($now);
        $minutesElapsed = $orderDate->diffInMinutes($now);

        $status = 'Order Placed';
        $statusIndex = 0;
        $estimatedDelivery = $orderDate->copy()->addHours(4)->format('M j, Y g:i A'); // 4 hours for local delivery

        if ($minutesElapsed >= 30) { // 30 minutes
            $status = 'Preparing Order';
            $statusIndex = 1;
        }
        if ($hoursElapsed >= 1) { // 1 hour
            $status = 'Order Ready';
            $statusIndex = 2;
        }
        if ($hoursElapsed >= 2) { // 2 hours
            $status = 'Out for Delivery';
            $statusIndex = 3;
        }
        if ($hoursElapsed >= 3) { // 3 hours
            $status = 'Delivered';
            $statusIndex = 4;
        }

        return view('order-tracking', compact('order', 'status', 'statusIndex', 'estimatedDelivery'));
    }
}
