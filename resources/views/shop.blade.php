@extends('layouts.app')

@section('content')
<section>
	<!-- Hidden input to pass authentication status -->
	<input type="hidden" id="auth-status" value="{{ auth()->check() ? 'true' : 'false' }}">

	<div class="sectionshop">
		<h1>Products</h1><br>
	<div class="shop-container row">
			@foreach($products as $product)
				<div class="product-column col-lg-3 col-md-4 col-sm-6 col-6">
					<div class="product-card">
						<img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
						<h1>{{ $product->name }}</h1>
						<p class="edu-school">₱{{ number_format($product->price, 2) }}</p>
						<button type="button" class="order-btn"
								data-product-id="{{ $product->id }}"
								data-product-name="{{ $product->name }}"
								data-product-price="{{ $product->price }}"
								data-product-image="{{ asset($product->image) }}"
								data-product-description="{{ $product->description }}"
								onclick="openProductModal(this)">ORDER</button>
					</div>
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

				<div class="modal-buttons">
					<button type="submit" class="add-to-cart-btn">
						ADD TO CART
					</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		// Modal functionality
		function openProductModal(button) {
			const productId = button.getAttribute('data-product-id');
			const productName = button.getAttribute('data-product-name');
			const productPrice = button.getAttribute('data-product-price');
			const productImage = button.getAttribute('data-product-image');
			const productDescription = button.getAttribute('data-product-description');

			// Populate modal with product data
			document.getElementById('modalProductId').value = productId;
			document.getElementById('modalProductName').textContent = productName;
			document.getElementById('modalProductImg').src = productImage;
			document.getElementById('modalProductImg').alt = productName;
			document.getElementById('modalProductPrice').textContent = '₱' + parseFloat(productPrice).toFixed(2);
			document.getElementById('modalProductDescription').textContent = productDescription;

			// Reset quantity to 1
			document.getElementById('modalQuantity').value = 1;
			document.getElementById('quantityDisplay').textContent = 1;

			// Show modal
			document.getElementById('productModal').classList.add('active');
		}

		function closeModal() {
			document.getElementById('productModal').classList.remove('active');
		}

		function increaseQuantity() {
			const quantityInput = document.getElementById('modalQuantity');
			const quantityDisplay = document.getElementById('quantityDisplay');
			let quantity = parseInt(quantityInput.value);
			quantity++;
			quantityInput.value = quantity;
			quantityDisplay.textContent = quantity;
		}

		function decreaseQuantity() {
			const quantityInput = document.getElementById('modalQuantity');
			const quantityDisplay = document.getElementById('quantityDisplay');
			let quantity = parseInt(quantityInput.value);
			if (quantity > 1) {
				quantity--;
				quantityInput.value = quantity;
				quantityDisplay.textContent = quantity;
			}
		}

		// Close modal when clicking outside
		document.addEventListener('click', function(e) {
			const modal = document.getElementById('productModal');
			if (e.target === modal) {
				closeModal();
			}
		});

		// Handle form submissions
		document.addEventListener('DOMContentLoaded', function() {
			const orderForm = document.getElementById('addToCartForm');
			const authStatus = document.getElementById('auth-status').value === 'true';

			if (orderForm) {
				orderForm.addEventListener('submit', function(e) {
					if (!authStatus) {
						e.preventDefault();
						// Redirect to login with return URL
						const currentUrl = encodeURIComponent(window.location.href);
						window.location.href = '{{ route("login") }}?redirect=' + currentUrl;
						return false;
					}
					// Close modal on successful submission
					closeModal();
				});
			}
		});



		// Close success modal functionality
		function closeSuccessModal() {
			const modal = document.getElementById('successModal');
			if (modal) {
				modal.style.display = 'none';
			}
		}

		// Make sure closeSuccessModal is available
		if (typeof closeSuccessModal === 'function') {
			// Attach event listeners when modal is shown
			var closeBtn = document.querySelector('.success-close-btn');
			var addMoreBtn = document.querySelector('.success-btn-secondary');

			if (closeBtn) closeBtn.addEventListener('click', closeSuccessModal);
			if (addMoreBtn) addMoreBtn.addEventListener('click', closeSuccessModal);
		}
	</script>
</section>
@endsection
