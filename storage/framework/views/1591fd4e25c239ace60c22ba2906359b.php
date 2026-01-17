<?php $__env->startSection('content'); ?>
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
                    <span class="order-info-value">#<?php echo e($order->id); ?></span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Name:</span>
                    <span class="order-info-value"><?php echo e($order->name); ?></span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Email:</span>
                    <span class="order-info-value"><?php echo e($order->email); ?></span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Phone:</span>
                    <span class="order-info-value"><?php echo e($order->phone); ?></span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Delivery Option:</span>
                    <span class="order-info-value"><?php echo e(ucfirst($order->delivery_option ?? 'Delivery')); ?></span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Delivery Address:</span>
                    <span class="order-info-value"><?php echo e($order->delivery_address); ?></span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Status:</span>
                    <span class="order-status-badge status-<?php echo e($order->status); ?>">
                        <?php echo e(ucfirst($order->status)); ?>

                    </span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Total:</span>
                    <span class="order-total-value">₱<?php echo e(number_format($order->total, 2)); ?></span>
                </div>
            </div>

            <h5 class="order-items-title">Items Ordered:</h5>
            <div class="order-items-list">
                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="order-item-row">
                        <span class="item-name"><?php echo e($item->product->name); ?> x <?php echo e($item->quantity); ?></span>
                        <span class="item-price">₱<?php echo e(number_format($item->price * $item->quantity, 2)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="order-confirmation-actions">
            <a href="<?php echo e(route('home')); ?>" class="action-btn action-btn-primary">Back to Home</a>
            <a href="<?php echo e(route('order.track', $order->id)); ?>" class="action-btn action-btn-secondary">Track Order</a>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Christopher x Angel\Documents\chibi_bites\resources\views/order-confirmation.blade.php ENDPATH**/ ?>