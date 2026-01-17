

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
            <div class="cart-container">
                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="cart-item">
                        <img src="<?php echo e(asset($item['product']->image)); ?>" alt="<?php echo e($item['product']->name); ?>">
                        <div class="cart-item-details">
                            <h3><?php echo e($item['product']->name); ?></h3>
                            <p><?php echo e($item['product']->description); ?></p>
                            <div class="cart-item-controls">
                                <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="quantity-form">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($item['product']->id); ?>">
                                    <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1" class="quantity-input">
                                    <button type="submit" class="update-btn">Update</button>
                                </form>
                                <span class="price">₱<?php echo e(number_format($item['subtotal'], 2)); ?></span>
                                <form action="<?php echo e(route('cart.remove', $item['product']->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="cart-summary">
                    <h4>Order Summary</h4>
                    <p><strong>Total: ₱<?php echo e(number_format($total, 2)); ?></strong></p>
                    <a href="<?php echo e(route('checkout')); ?>" class="checkout-btn">Proceed to Checkout</a>
                    <form action="<?php echo e(route('cart.clear')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="clear-btn">Clear Cart</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Christopher x Angel\Documents\chibi_bites\laravel\resources\views/cart.blade.php ENDPATH**/ ?>