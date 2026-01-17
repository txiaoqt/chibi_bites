@extends('layouts.app')

@section('content')
<section style="padding: 140px 20px; min-height: 80vh;">
    <div class="account-container">
        <div class="account-header">
            <h1 class="account-title">My Account</h1>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <h3 class="account-subtitle">Order History</h3>
        @if($orders->isEmpty())
            <div class="empty-orders">
                <p>You have no orders yet.</p>
                <a href="{{ route('shop') }}" class="shop-link">Start Shopping</a>
            </div>
        @else
            <div class="orders-container">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-content">
                            <div class="order-info">
                                <h4 class="order-number">Order #{{ $order->id }}</h4>
                                <p class="order-detail"><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                                <p class="order-detail">
                                    <strong>Status:</strong>
                                    <span class="order-status status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                                <p class="order-detail order-total"><strong>Total:</strong> ₱{{ number_format($order->total, 2) }}</p>
                            </div>
                            <div class="order-items">
                                <h5 class="items-title">Items Ordered:</h5>
                                <div class="items-list">
                                    @foreach($order->orderItems as $item)
                                        <div class="item-row">
                                            <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                            <span class="item-price">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
