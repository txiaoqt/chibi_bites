

<?php $__env->startSection('content'); ?>
<section>
	<!-- Hidden input to pass authentication status -->
	<input type="hidden" id="auth-status" value="<?php echo e(auth()->check() ? 'true' : 'false'); ?>">

	<div class="sectionshop">
		<h1>Products</h1><br>
	<div class="shop-container row">
			<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="product-column col-lg-3 col-md-4 col-sm-6">
					<form action="<?php echo e(route('cart.add')); ?>" method="POST" class="order-form">
						<?php echo csrf_field(); ?>
						<input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
						<input type="hidden" name="quantity" value="1">
						<div class="product-card">
							<img src="<?php echo e(asset($product->image)); ?>" alt="<?php echo e($product->name); ?>">
							<h1><?php echo e($product->name); ?></h1>
							<p class="edu-school">₱<?php echo e(number_format($product->price, 2)); ?></p>
							<button type="submit" class="order-btn">ORDER</button>
						</div>
					</form>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>

	<!-- Success Modal -->
	<?php if(session('cart_success')): ?>
	<div id="successModal" class="success-modal">
		<div class="success-modal-content">
			<a href="<?php echo e(url()->current()); ?>" class="success-close-btn">&times;</a>
			<div class="success-modal-body">
				<div class="success-icon">
					✓
				</div>
				<h2 class="success-title">Success!</h2>
				<p class="success-message"><?php echo e(session('cart_success')); ?></p>
				<div class="success-buttons">
					<a href="<?php echo e(url()->current()); ?>" class="success-btn success-btn-secondary">Add More</a>
					<a href="<?php echo e(route('cart.index')); ?>" class="success-btn success-btn-primary">View Cart</a>
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
	<?php endif; ?>

	<!-- Modal -->
	<div id="productModal" class="modal">
		<div class="modal-content">
			<button class="close-btn" onclick="closeModal()">&times;</button>
			<form id="addToCartForm" action="<?php echo e(route('cart.add')); ?>" method="POST" class="order-form">
				<?php echo csrf_field(); ?>
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
						window.location.href = '<?php echo e(route("login")); ?>?redirect=' + currentUrl;
						return false;
					}
				});
			});
		});
	</script>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Christopher x Angel\Documents\chibi_bites\laravel\resources\views/shop.blade.php ENDPATH**/ ?>