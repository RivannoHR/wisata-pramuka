<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="product-card">
        <?php if($product->image_path): ?>
        <div class="product-card-image">
            <img src="<?php echo e(asset('storage/' . $product->image_path)); ?>" alt="<?php echo e($product->title); ?>">
        </div>
        <?php else: ?>
        <div class="product-card-image placeholder">
            <div class="placeholder-text">No Image</div>
        </div>
        <?php endif; ?>

        <div class="product-card-content">
            <h3 class="product-card-title"><?php echo e($product->title); ?></h3>
            <p class="product-card-description"><?php echo e(Str::limit($product->description, 100)); ?></p>

            <div class="product-card-details">
                <div class="product-price">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></div>
                <div class="product-stock <?php echo e($product->stock <= 0 ? 'out-of-stock' : ($product->stock <= 5 ? 'low-stock' : 'in-stock')); ?>">
                    <?php if($product->stock <= 0): ?>
                        Out of Stock
                    <?php elseif($product->stock <= 5): ?>
                        Low Stock (<?php echo e($product->stock); ?>)
                    <?php else: ?>
                        In Stock (<?php echo e($product->stock); ?>)
                    <?php endif; ?>
                </div>
            </div>

            <div class="product-card-actions">
                <a href="<?php echo e(route('products.show', $product->product_id)); ?>" class="view-button">View Details</a>
                <?php if($product->stock > 0): ?>
                <a href="http://wa.me/6281213643354?text=Saya tertarik untuk memesan <?php echo e($product->title); ?>" class="order-button">Make Order</a>
                <?php else: ?>
                <a href="#" class="order-button disabled">Out of Stock</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/products/partials/product-cards.blade.php ENDPATH**/ ?>