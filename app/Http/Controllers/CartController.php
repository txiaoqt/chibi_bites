<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = [];
        $total = 0;

        if (Auth::check()) {
            // For authenticated users, get cart from database
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $userCartItems = $user->cartItems()->with('product')->get();

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

        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        $product = Product::find($productId);
        if (!$product) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }
            return redirect()->back()->with('error', 'Product not found');
        }

        if (Auth::check()) {
            // For authenticated users, save to database
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $cartItem = $user->cartItems()->where('product_id', $productId)->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                $user->cartItems()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            // For guests, save to session
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }
            session()->put('cart', $cart);
        }

        if ($request->expectsJson()) {
            if (Auth::check()) {
                /** @var \App\Models\User $user */
                $user = Auth::user();
                $cartCount = $user->cartItems()->sum('quantity');
            } else {
                $cartCount = array_sum(session()->get('cart', []));
            }
            return response()->json(['success' => true, 'cart_count' => $cartCount]);
        }

        // For form submissions, redirect back with success message
        return redirect()->back()->with('cart_success', $product->name . ' successfully added to cart');
    }

    public function update(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;

        if (Auth::check()) {
            // For authenticated users, update database
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if ($quantity > 0) {
                $user->cartItems()->updateOrCreate(
                    ['product_id' => $productId],
                    ['quantity' => $quantity]
                );
            } else {
                $user->cartItems()->where('product_id', $productId)->delete();
            }
        } else {
            // For guests, update session
            $cart = session()->get('cart', []);
            if ($quantity > 0) {
                $cart[$productId] = $quantity;
            } else {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function remove($id)
    {
        if (Auth::check()) {
            // For authenticated users, remove from database
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->cartItems()->where('product_id', $id)->delete();
        } else {
            // For guests, remove from session
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function clear()
    {
        if (Auth::check()) {
            // For authenticated users, clear database cart
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->cartItems()->delete();
        } else {
            // For guests, clear session cart
            session()->forget('cart');
        }
        return redirect()->route('cart.index');
    }
}
