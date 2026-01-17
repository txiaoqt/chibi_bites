<?php $__env->startSection('content'); ?>
<section style="padding: 140px 20px; min-height: 80vh;">
    <div class="checkout-container">
        <h1 class="checkout-title">Checkout</h1>

        <form action="<?php echo e(route('orders.store')); ?>" method="POST" class="checkout-form">
            <?php echo csrf_field(); ?>
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
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="order-item">
                                <span><?php echo e($item['product']->name); ?> x <?php echo e($item['quantity']); ?></span>
                                <span>₱<?php echo e(number_format($item['subtotal'], 2)); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <hr class="order-divider">
                    <div class="order-total">
                        <strong>Total</strong>
                        <strong>₱<?php echo e(number_format($total, 2)); ?></strong>
                    </div>
                    <button type="submit" class="checkout-submit-btn">Place Order</button>
                </div>
            </div>
        </form>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Christopher x Angel\Documents\chibi_bites\resources\views/checkout.blade.php ENDPATH**/ ?>