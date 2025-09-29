<?php $__env->startSection('title', $product->title . ' - Pulau Pramuka'); ?>

<?php $__env->startSection('content'); ?>
    <section class="product-detail-section">
        <div class="product-detail-container">
            <a href="<?php echo e(route('products.index')); ?>" class="back-button">← Back to Products</a>
            
            <div class="product-detail-grid">
                <div class="product-detail-image">
                    <?php if($product->image_path): ?>
                        <img src="<?php echo e(asset('storage/' . $product->image_path)); ?>" alt="<?php echo e($product->title); ?>">
                    <?php else: ?>
                        <div class="placeholder-image">
                            <div class="placeholder-text">No Image Available</div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="product-detail-info">
                    <h1 class="product-title"><?php echo e($product->title); ?></h1>
                    <div class="product-price">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></div>
                    
                    <div class="product-stock-status <?php echo e($product->stock <= 0 ? 'out-of-stock' : ($product->stock <= 5 ? 'low-stock' : 'in-stock')); ?>">
                        <?php if($product->stock <= 0): ?>
                            <span class="stock-badge out-of-stock">Out of Stock</span>
                        <?php elseif($product->stock <= 5): ?>
                            <span class="stock-badge low-stock">Low Stock - Only <?php echo e($product->stock); ?> left</span>
                        <?php else: ?>
                            <span class="stock-badge in-stock"><?php echo e($product->stock); ?> in stock</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-description">
                        <h3>Description</h3>
                        <p><?php echo e($product->description); ?></p>
                    </div>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if($product->stock > 0): ?>
                            <div class="product-actions">
                                <div class="quantity-selector">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" name="quantity" min="1" max="<?php echo e($product->stock); ?>" value="1" class="quantity-input">
                                </div>
                                <button class="order-button" onclick="makeOrder()">Make Order</button>
                            </div>
                        <?php else: ?>
                            <div class="product-actions">
                                <button class="order-button disabled" disabled>Out of Stock</button>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="product-actions">
                            <a href="http://wa.me/6281213643354?text=Saya tertarik untuk memesan <?php echo e($product->title); ?>" class="order-button">Make Order</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <script>
        function makeOrder() {
            const quantity = document.getElementById('quantity').value;
            const productTitle = "<?php echo e($product->title); ?>";
            const productPrice = "<?php echo e(number_format($product->price, 0, ',', '.')); ?>";
            const totalPrice = <?php echo e($product->price); ?> * quantity;
            const formattedTotalPrice = totalPrice.toLocaleString('id-ID');
            
            const message = `Saya tertarik untuk memesan:
Produk: ${productTitle}
Jumlah: ${quantity}
Harga satuan: Rp ${productPrice}
Total harga: Rp ${formattedTotalPrice}

Terima kasih!`;
            
            const whatsappUrl = `http://wa.me/6281213643354?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/products/show.blade.php ENDPATH**/ ?>