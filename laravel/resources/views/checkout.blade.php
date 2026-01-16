@extends('layouts.app')

@section('content')
<section style="padding: 140px 20px; min-height: 80vh;">
    <div class="checkout-container">
        <h1 class="checkout-title">Checkout</h1>

        <form action="{{ route('orders.store') }}" method="POST" class="checkout-form">
            @csrf
            <div class="checkout-content">
                <div class="checkout-info">
                    <h4 class="checkout-subtitle">Customer Information</h4>
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-input" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-input" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-input" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="delivery_option" class="form-label">Delivery Option</label>
                        <select class="form-select" id="delivery_option" name="delivery_option" required>
                            <option value="pickup">Pickup</option>
                            <option value="delivery">Delivery</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="delivery_address" class="form-label">Delivery Address</label>
                        <textarea class="form-textarea" id="delivery_address" name="delivery_address" rows="3" required></textarea>
                    </div>
                </div>
                <div class="checkout-summary">
                    <h4 class="checkout-subtitle">Order Summary</h4>
                    <div class="order-items">
                        @foreach($cartItems as $item)
                            <div class="order-item">
                                <span>{{ $item['product']->name }} x {{ $item['quantity'] }}</span>
                                <span>₱{{ number_format($item['subtotal'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <hr class="order-divider">
                    <div class="order-total">
                        <strong>Total</strong>
                        <strong>₱{{ number_format($total, 2) }}</strong>
                    </div>
                    <button type="submit" class="checkout-submit-btn">Place Order</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
