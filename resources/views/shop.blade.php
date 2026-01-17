@extends('layouts.app')

@section('content')
<section>
	<!-- Hidden input to pass authentication status -->
	<input type="hidden" id="auth-status" value="{{ auth()->check() ? 'true' : 'false' }}">

	<div class="sectionshop">
		<h1>Products</h1><br>
	<div class="shop-container row">
			@foreach($products as $product)
				<div class="product-column col-lg-3 col-md-4 col-sm-6">
					<form action="{{ route('cart.add') }}" method="POST" class="order-form">
						@csrf
						<input type="hidden" name="product_id" value="{{ $product->id }}">
						<input type="hidden" name="quantity" value="1">
						<div class="product-card">
							<img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
							<h1>{{ $product->name }}</h1>
							<p class="edu-school">₱{{ number_format($product->price, 2) }}</p>
							<button type="submit" class="order-btn">ORDER</button>
						</div>
					</form>
				</div>
			@endforeach
		</div>
	</div>

	<!-- Success Modal -->
	@if(session('cart_success'))
	<div id="successModal" class="success-modal">
		<div class="success-modal-content">
			<a href="{{ url()->current() }}" class="success-close-btn">&times;</a>
			<div class="success-modal-body">
				<div class="success-icon">
					✓
				</div>
				<h2 class="success-title">Success!</h2>
				<p class="success-message">{{ session('cart_success') }}</p>
				<div class="success-buttons">
					<a href="{{ url()->current() }}" class="success-btn success-btn-secondary">Add More</a>
					<a href="{{ route('cart.index') }}" class="success-btn success-btn-primary">View Cart</a>
				</div>
			</div>
		</div>
	</div>
	<script>
		// Make sure closeSuccessModal is available
		if (typeof closeSuccessModal === 'function') {
			// Attach event listeners when modal is shown
			var closeBtn = document.querySelector('.success-close-btn');
			var addMoreBtn = document.querySelector('.success-btn-secondary');

			if (closeBtn) closeBtn.addEventListener('click', closeSuccessModal);
			if (addMoreBtn) addMoreBtn.addEventListener('click', closeSuccessModal);
		}
	</script>
	@endif

	<!-- Modal -->
	<div id="productModal" class="modal">
		<div class="modal-content">
			<button class="close-btn" onclick="closeModal()">&times;</button>
			<form id="addToCartForm" action="{{ route('cart.add') }}" method="POST" class="order-form">
				@csrf
				<input type="hidden" name="product_id" id="modalProductId" value="">
				<input type="hidden" name="quantity" id="modalQuantity" value="1">

				<h2 id="modalProductName">Product Name</h2>
				<img id="modalProductImg" src="" alt="Product" class="modal-product-img">
				<div class="modal-price" id="modalProductPrice">₱200.00</div>
				<p class="modal-description" id="modalProductDescription">Product description goes here.</p>

				<div class="quantity-selector">
					<button type="button" class="quantity-btn" onclick="decreaseQuantity()">−</button>
					<span class="quantity-display" id="quantityDisplay">1</span>
					<button type="button" class="quantity-btn" onclick="increaseQuantity()">+</button>
				</div>

				<button type="submit" class="add-to-cart-btn">
					ADD TO CART
				</button>
			</form>
		</div>
	</div>

	<script>
		// Handle order form submissions
		document.addEventListener('DOMContentLoaded', function() {
			const orderForms = document.querySelectorAll('.order-form');
			const authStatus = document.getElementById('auth-status').value === 'true';

			orderForms.forEach(form => {
				form.addEventListener('submit', function(e) {
					if (!authStatus) {
						e.preventDefault();
						// Redirect to login with return URL
						const currentUrl = encodeURIComponent(window.location.href);
						window.location.href = '{{ route("login") }}?redirect=' + currentUrl;
						return false;
					}
				});
			});
		});
	</script>
</section>
@endsection
