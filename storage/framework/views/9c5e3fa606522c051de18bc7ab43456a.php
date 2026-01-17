<?php $__env->startSection('content'); ?>
<section style="padding: 140px 20px; min-height: 80vh;">
    <div class="container">
        <h1 class="text-center mb-4">Your Cart</h1>

<?php if(empty($cartItems)): ?>
    <div class="empty-cart-message">
        <div class="empty-cart-icon">🛒</div>
        <h3 class="empty-cart-title">Your Cart is Empty</h3>
        <p class="empty-cart-text">Looks like you haven't added any delicious mochi to your cart yet!</p>
        <a href="<?php echo e(route('shop')); ?>" class="empty-cart-btn">Start Shopping</a>
    </div>
<?php else: ?>
    <!-- Separate update and remove forms (not nested in checkout form) -->
    <div class="cart-forms-container" style="display: none;">
        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Individual update form for each item -->
            <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="update-form" id="update-form-<?php echo e($index); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($item['product']->id); ?>">
                <input type="hidden" name="quantity" id="quantity-<?php echo e($index); ?>">
            </form>
            <!-- Individual remove form for each item -->
            <form action="<?php echo e(route('cart.remove', $item['product']->id)); ?>" method="POST" class="remove-form" id="remove-form-<?php echo e($index); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            </form>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <!-- Clear cart form -->
        <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="clear-form" id="clear-form">
            <?php echo csrf_field(); ?>
        </form>
    </div>

    <!-- Checkout form (contains only checkout-related elements) -->
    <form id="checkoutForm" action="<?php echo e(route('checkout.selected')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="cart-container">
            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="cart-item" data-price="<?php echo e($item['subtotal']); ?>" data-product-id="<?php echo e($item['product']->id); ?>">
                    <div class="cart-item-checkbox">
                        <input type="checkbox" name="selected_items[]" value="<?php echo e($item['product']->id); ?>" id="item_<?php echo e($index); ?>">
                        <label for="item_<?php echo e($index); ?>"></label>
                    </div>
                    <img src="<?php echo e(asset($item['product']->image)); ?>" alt="<?php echo e($item['product']->name); ?>">
                    <div class="cart-item-details">
                        <h3><?php echo e($item['product']->name); ?></h3>
                        <p><?php echo e($item['product']->description); ?></p>
                        <div class="cart-item-controls">
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn" onclick="decreaseQuantity(<?php echo e($index); ?>)">−</button>
                                <input type="number" value="<?php echo e($item['quantity']); ?>" min="1" class="quantity-input" id="quantity-input-<?php echo e($index); ?>" onchange="updateQuantity(<?php echo e($index); ?>)">
                                <button type="button" class="quantity-btn" onclick="increaseQuantity(<?php echo e($index); ?>)">+</button>
                                <button type="button" class="update-btn" onclick="submitUpdate(<?php echo e($index); ?>)">Update</button>
                            </div>
                            <span class="price">₱<?php echo e(number_format($item['subtotal'], 2)); ?></span>
                            <button type="button" class="remove-btn" onclick="submitRemove(<?php echo e($index); ?>)">Remove</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="cart-summary">
                <h4>Order Summary</h4>
                <p><strong>Total: ₱0.00</strong></p>
                <button type="submit" class="checkout-btn" disabled>Proceed to Checkout</button>
                <button type="button" class="clear-btn" onclick="submitClear()">Clear Cart</button>
            </div>
        </div>
    </form>
<?php endif; ?>
    </div>
</section>

<script>
// Quantity control functions
function increaseQuantity(index) {
    const input = document.getElementById('quantity-input-' + index);
    let quantity = parseInt(input.value);
    quantity++;
    input.value = quantity;
    updateQuantity(index);
}

function decreaseQuantity(index) {
    const input = document.getElementById('quantity-input-' + index);
    let quantity = parseInt(input.value);
    if (quantity > 1) {
        quantity--;
        input.value = quantity;
        updateQuantity(index);
    }
}

function updateQuantity(index) {
    const input = document.getElementById('quantity-input-' + index);
    const quantity = parseInt(input.value);
    document.getElementById('quantity-' + index).value = quantity;
}

function submitUpdate(index) {
    const form = document.getElementById('update-form-' + index);
    const quantityInput = document.getElementById('quantity-input-' + index);
    document.getElementById('quantity-' + index).value = quantityInput.value;
    form.submit();
}

function submitRemove(index) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        const form = document.getElementById('remove-form-' + index);
        form.submit();
    }
}

function submitClear() {
    if (confirm('Are you sure you want to clear your entire cart?')) {
        const form = document.getElementById('clear-form');
        form.submit();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
    const totalDisplay = document.querySelector('.cart-summary p strong');
    const checkoutBtn = document.querySelector('.checkout-btn');
    const checkoutForm = document.getElementById('checkoutForm');

    // Function to calculate and update total
    function updateTotal() {
        let total = 0;
        let checkedCount = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const cartItem = checkbox.closest('.cart-item');
                const price = parseFloat(cartItem.getAttribute('data-price'));
                total += price;
                checkedCount++;
            }
        });

        // Update total display
        totalDisplay.textContent = '₱' + total.toFixed(2);

        // Enable/disable checkout button based on selections
        checkoutBtn.disabled = checkedCount === 0;
        if (checkedCount === 0) {
            checkoutBtn.style.opacity = '0.5';
            checkoutBtn.style.cursor = 'not-allowed';
        } else {
            checkoutBtn.style.opacity = '1';
            checkoutBtn.style.cursor = 'pointer';
        }
    }

    // Add event listeners to checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotal);
    });

    // Initial calculation
    updateTotal();

    // Form validation
    checkoutForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('input[name="selected_items[]"]:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one item to checkout.');
            return false;
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Christopher x Angel\Documents\chibi_bites\resources\views/cart.blade.php ENDPATH**/ ?>