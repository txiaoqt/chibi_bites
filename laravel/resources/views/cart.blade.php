@extends('layouts.app')

@section('content')
<section style="padding: 140px 20px; min-height: 80vh;">
    <div class="container">
        <h1 class="text-center mb-4">Your Cart</h1>

        @if(empty($cartItems))
            <div class="empty-cart-message">
                <div class="empty-cart-icon">🛒</div>
                <h3 class="empty-cart-title">Your Cart is Empty</h3>
                <p class="empty-cart-text">Looks like you haven't added any delicious mochi to your cart yet!</p>
                <a href="{{ route('shop') }}" class="empty-cart-btn">Start Shopping</a>
            </div>
        @else
            <div class="cart-container">
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <img src="{{ asset($item['product']->image) }}" alt="{{ $item['product']->name }}">
                        <div class="cart-item-details">
                            <h3>{{ $item['product']->name }}</h3>
                            <p>{{ $item['product']->description }}</p>
                            <div class="cart-item-controls">
                                <form action="{{ route('cart.update') }}" method="POST" class="quantity-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input">
                                    <button type="submit" class="update-btn">Update</button>
                                </form>
                                <span class="price">₱{{ number_format($item['subtotal'], 2) }}</span>
                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="cart-summary">
                    <h4>Order Summary</h4>
                    <p><strong>Total: ₱{{ number_format($total, 2) }}</strong></p>
                    <a href="{{ route('checkout') }}" class="checkout-btn">Proceed to Checkout</a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="clear-btn">Clear Cart</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
