<?php $__env->startSection('content'); ?>
<section style="padding: 140px 20px; min-height: 80vh;">
    <div class="account-container">
        <div class="account-header">
            <h1 class="account-title">My Account</h1>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <h3 class="account-subtitle">Order History</h3>
        <?php if($orders->isEmpty()): ?>
            <div class="empty-orders">
                <p>You have no orders yet.</p>
                <a href="<?php echo e(route('shop')); ?>" class="shop-link">Start Shopping</a>
            </div>
        <?php else: ?>
            <div class="orders-container">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="order-card">
                        <div class="order-content">
                            <div class="order-info">
                                <h4 class="order-number">Order #<?php echo e($order->id); ?></h4>
                                <p class="order-detail"><strong>Date:</strong> <?php echo e($order->created_at->format('M d, Y H:i')); ?></p>
                                <p class="order-detail">
                                    <strong>Status:</strong>
                                    <span class="order-status status-<?php echo e($order->status); ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </p>
                                <p class="order-detail order-total"><strong>Total:</strong> ₱<?php echo e(number_format($order->total, 2)); ?></p>
                                <a href="<?php echo e(route('order.track', $order->id)); ?>" class="track-order-btn">Track Order</a>
                            </div>
                            <div class="order-items">
                                <h5 class="items-title">Items Ordered:</h5>
                                <div class="items-list">
                                    <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="item-row">
                                            <span><?php echo e($item->product->name); ?> x <?php echo e($item->quantity); ?></span>
                                            <span class="item-price">₱<?php echo e(number_format($item->price * $item->quantity, 2)); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Christopher x Angel\Documents\chibi_bites\resources\views/account.blade.php ENDPATH**/ ?>