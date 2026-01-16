<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Migrate session cart to database for authenticated user
            $this->migrateSessionCartToDatabase();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    private function migrateSessionCartToDatabase()
    {
        $sessionCart = session()->get('cart', []);
        if (!empty($sessionCart) && Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            foreach ($sessionCart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $existingCartItem = $user->cartItems()->where('product_id', $productId)->first();

                    if ($existingCartItem) {
                        $existingCartItem->quantity += $quantity;
                        $existingCartItem->save();
                    } else {
                        $user->cartItems()->create([
                            'product_id' => $productId,
                            'quantity' => $quantity,
                        ]);
                    }
                }
            }

            // Clear session cart after migration
            session()->forget('cart');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
