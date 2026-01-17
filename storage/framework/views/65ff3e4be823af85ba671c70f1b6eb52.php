<?php $__env->startSection('content'); ?>
<section class="section section-1">
    <section class="container">
        <div class="slider-wrapper">

            <div class="slider">
                <img id="slide-1" src="<?php echo e(asset('images/homeslide1.png')); ?>" alt="Slide 1">
                <img id="slide-2" src="<?php echo e(asset('images/homeslide2.png')); ?>" alt="Slide 2">
            </div>

            <div class="slider-nav">
                <a href="#slide-1"></a>
                <a href="#slide-2"></a>
            </div>

        </div>
    </section>
</section>

    <!-- SECTION 2 -->
    <section class="section section-2">
        <section class="section section-2">
    <div class="center-div">
        <div class="left-div">
            <h1>What is Mochi?</h1><br>
            <p>Mochi is a traditional Japanese sweet made from glutinous rice that's pounded into a smooth, elastic paste and molded into various shapes. It's incredibly soft and chewy, often filled with sweet red bean paste, ice cream, or fruit, making it a delightful and unique treat loved worldwide for its delicate texture and versatility.</p>
        </div>
        <div class="right-div">
             <img src="<?php echo e(asset('images/whatismochi.jpg')); ?>" alt="Mochi" class="right-img">
        </div>
    </div>
</section>
    </section>

    <!-- SECTION 3 -->
   <section class="section section-3">
    <section class="container">
        <div class="slider-wrapper">

            <div class="slider">
                <img id="slide-1" src="<?php echo e(asset('images/bestseller1.png')); ?>" alt="Slide 1">
                <img id="slide-2" src="<?php echo e(asset('images/bestseller2.png')); ?>" alt="Slide 2">
            </div>

            <div class="slider-nav">
                <a href="#slide-1"></a>
                <a href="#slide-2"></a>
            </div>

        </div>
    </section>
</section>

<!-- SECTION 2 -->
    <section class="section section-4">
        <section class="section section-4">
    <div class="center-div">
        <div class="left-div">
            <a href="<?php echo e(route('shop')); ?>">
                <img src="<?php echo e(asset('images/shopnow.png')); ?>" alt="Shop Now" class="right-img">
            </a>
        </div>
        <div class="right-div">
             <img src="<?php echo e(asset('images/storeloc.png')); ?>" alt="Mochi" class="right-img">
        </div>
    </div>
</section>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Christopher x Angel\Documents\chibi_bites\resources\views/home.blade.php ENDPATH**/ ?>