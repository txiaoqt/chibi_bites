@extends('layouts.app')

@section('content')
<section style="padding: 140px 20px; min-height: 80vh;">
    <div class="order-tracking-container">
        <!-- Header -->
        <div class="tracking-header">
            <h1 class="tracking-title">Order Tracking</h1>
            <p class="tracking-disclaimer">
                Delivery estimates are based on local city delivery times and may vary due to traffic or other factors.
            </p>
        </div>

        <!-- Order Summary Box -->
        <div class="order-summary-card">
            <div class="order-summary-grid">
                <div class="summary-item">
                    <span class="summary-label">Order Placed</span>
                    <span class="summary-value">{{ $order->created_at->format('M j, Y') }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Total</span>
                    <span class="summary-value">₱{{ number_format($order->total, 2) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Ship To</span>
                    <span class="summary-value">{{ Str::limit($order->name, 20) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Order #</span>
                    <span class="summary-value">#{{ $order->id }}</span>
                </div>
            </div>
        </div>

        <!-- Status Indicator -->
        <div class="status-indicator">
            <div class="status-text">
                <h2>Order Status: <span class="status-highlight">{{ $status }}</span></h2>
                <p class="delivery-estimate">Estimated Delivery: {{ $estimatedDelivery }}</p>
            </div>
        </div>

        <!-- Timeline Tracker -->
        <div class="timeline-tracker">
            <div class="timeline-progress">
                <div class="progress-bar" style="width: {{ ($statusIndex / 4) * 100 }}%"></div>
            </div>
            <div class="timeline-steps">
                <div class="timeline-step {{ $statusIndex >= 0 ? 'completed' : 'pending' }}">
                    <div class="step-icon">📦</div>
                    <div class="step-label">Order Placed</div>
                    <div class="step-check">✓</div>
                </div>
                <div class="timeline-step {{ $statusIndex >= 1 ? 'completed' : 'pending' }}">
                    <div class="step-icon">👨‍🍳</div>
                    <div class="step-label">Preparing Order</div>
                    <div class="step-check">✓</div>
                </div>
                <div class="timeline-step {{ $statusIndex >= 2 ? 'active' : ($statusIndex > 2 ? 'completed' : 'pending') }}">
                    <div class="step-icon">✅</div>
                    <div class="step-label">Order Ready</div>
                    <div class="step-check">✓</div>
                </div>
                <div class="timeline-step {{ $statusIndex >= 3 ? 'active' : ($statusIndex > 3 ? 'completed' : 'pending') }}">
                    <div class="step-icon">🚴</div>
                    <div class="step-label">Out for Delivery</div>
                    <div class="step-check">✓</div>
                </div>
                <div class="timeline-step {{ $statusIndex >= 4 ? 'completed' : 'pending' }}">
                    <div class="step-icon">🏠</div>
                    <div class="step-label">Delivered</div>
                    <div class="step-check">✓</div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="tracking-order-items">
            <h3>Items in Your Order</h3>
            <div class="tracking-items-list">
                @foreach($order->orderItems as $item)
                    <div class="tracking-item-row">
                        <span class="item-name">{{ $item->product->name }} x {{ $item->quantity }}</span>
                        <span class="item-price">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Actions -->
        <div class="tracking-actions">
            <a href="{{ route('account') }}" class="action-btn action-btn-primary">View All Orders</a>
            <a href="{{ route('home') }}" class="action-btn action-btn-secondary">Back to Home</a>
        </div>
    </div>
</section>
@endsection
