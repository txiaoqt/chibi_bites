@extends('layouts.app')

@section('content')
<section style="padding: 140px 20px; min-height: 80vh;">
    <div class="order-confirmation-container">
        <div class="order-confirmation-header">
            <div class="success-icon-large">
                ✓
            </div>
            <h1 class="order-confirmation-title">Order Confirmed!</h1>
            <p class="order-confirmation-subtitle">Thank you for your order. Your order has been placed successfully.</p>
        </div>

        <div class="order-details-card">
            <h4 class="order-details-title">Order Details</h4>

            <div class="order-info-grid">
                <div class="order-info-item">
                    <span class="order-info-label">Order ID:</span>
                    <span class="order-info-value">#{{ $order->id }}</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Name:</span>
                    <span class="order-info-value">{{ $order->name }}</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Email:</span>
                    <span class="order-info-value">{{ $order->email }}</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Phone:</span>
                    <span class="order-info-value">{{ $order->phone }}</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Delivery Option:</span>
                    <span class="order-info-value">{{ ucfirst($order->delivery_option ?? 'Delivery') }}</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Delivery Address:</span>
                    <span class="order-info-value">{{ $order->delivery_address }}</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Status:</span>
                    <span class="order-status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Total:</span>
                    <span class="order-total-value">₱{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <h5 class="order-items-title">Items Ordered:</h5>
            <div class="order-items-list">
                @foreach($order->orderItems as $item)
                    <div class="order-item-row">
                        <span class="item-name">{{ $item->product->name }} x {{ $item->quantity }}</span>
                        <span class="item-price">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="order-confirmation-actions">
            <a href="{{ route('home') }}" class="action-btn action-btn-primary">Back to Home</a>
            <a href="{{ route('account') }}" class="action-btn action-btn-secondary">View Account</a>
        </div>
    </div>
</section>
@endsection
