<?php $__env->startSection('title', 'Discover Pulau Pramuka - Your Gateway to Paradise'); ?>

<?php $__env->startSection('hero_content'); ?>
<div class="hero-content">
    <h1>Discover the Hidden Gems of Pulau Pramuka</h1>
    <p>Experience pristine beaches, crystal-clear waters, and unforgettable adventures in Indonesia's marine paradise.</p>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="products-section">
    <div class="section-header">
        <i class="fas fa-shopping-bag icon-circle"></i>
        <h2>Meet Our Specialties
        </h2>
    </div>

    
    <?php if($products->count() > 0): ?>
    <div class="horizontal-scroll-container">
        <div class="horizontal-scroll-track">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="horizontal-product-card">
                <div class="horizontal-product-image">
                    <?php if($product->image_path): ?>
                    <img src="<?php echo e(asset('storage/' . $product->image_path)); ?>" alt="<?php echo e($product->title); ?>">
                    <?php else: ?>
                    <div class="placeholder-image">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="horizontal-product-content">
                    <h3><?php echo e($product->title); ?></h3>
                    <p class="horizontal-product-description"><?php echo e(Str::limit($product->description, 80)); ?></p>
                    <?php if($product->price): ?>
                    <div class="horizontal-product-price">
                        Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                    </div>
                    <?php endif; ?>
                    <div class="horizontal-product-actions">
                        <a href="<?php echo e(route('products.show', $product->product_id)); ?>" class="horizontal-view-button-single">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <?php if($products->count() >= 3): ?>
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?php echo e(route('products.index')); ?>" class="view-all-button">
            <i class="fas fa-shopping-bag"></i>
            View All Products
        </a>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div class="no-products">
        <i class="fas fa-shopping-bag"></i>
        <h3>No products available</h3>
        <p>Check back later for our featured products!</p>
    </div>
    <?php endif; ?>
</section>


<section class="accommodations-section">
    <div class="section-header">
        <i class="fas fa-bed icon-circle"></i>
        <h2>Comfortable Accommodations</h2>
    </div>

    <?php if($accommodations->count() > 0): ?>
    <div class="horizontal-scroll-container">
        <div class="horizontal-scroll-track">
            <?php $__currentLoopData = $accommodations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accommodation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="horizontal-feature-card">
                <div class="card-image">
                    <?php if($accommodation->main_image): ?>
                    <img src="<?php echo e($accommodation->main_image); ?>" alt="<?php echo e($accommodation->name); ?>">
                    <?php else: ?>
                    <div class="placeholder-image">
                        <i class="fas fa-bed"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-content">
                    <h3><?php echo e($accommodation->name); ?></h3>
                    <p class="card-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo e($accommodation->location ?? 'Pulau Pramuka'); ?>

                    </p>
                    <p class="card-description"><?php echo e(Str::limit($accommodation->description, 100)); ?></p>
                    <div class="card-meta">
                        <?php if($accommodation->capacity): ?>
                        <span class="meta-item">
                            <i class="fas fa-users"></i>
                            Up to <?php echo e($accommodation->capacity); ?> guests
                        </span>
                        <?php endif; ?>
                        <?php if($accommodation->price_per_night): ?>
                        <span class="meta-price">
                            Starting Rp <?php echo e($accommodation->LowestPrice); ?>/night
                        </span>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo e(route('accommodations.show', $accommodation->id)); ?>" class="card-button">
                        Explore Now
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php else: ?>
    <div class="no-products">
        <i class="fas fa-bed"></i>
        <h3>No accommodations available</h3>
        <p>Check back later for our accommodations!</p>
    </div>
    <?php endif; ?>

    <?php if($accommodations->count() >= 3): ?>
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?php echo e(route('accommodations.index')); ?>" class="view-all-button">
            <i class="fas fa-th-large"></i>
            View All Accommodations
        </a>
    </div>
    <?php endif; ?>
</section>


<section class="attractions-section">
    <div class="section-header">
        <i class="fas fa-map-marked-alt icon-circle"></i>
        <h2>Amazing Tourist Attractions</h2>
    </div>

    <?php if($touristAttractions->count() > 0): ?>
    <div class="horizontal-scroll-container">
        <div class="horizontal-scroll-track">
            <?php $__currentLoopData = $touristAttractions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attraction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="horizontal-feature-card">
                <div class="card-image">
                    <?php if($attraction->main_image): ?>
                    <img src="<?php echo e($attraction->main_image); ?>" alt="<?php echo e($attraction->name); ?>">
                    <?php elseif($attraction->images->count() > 0): ?>
                    <img src="<?php echo e($attraction->images->first()->image_url); ?>" alt="<?php echo e($attraction->name); ?>">
                    <?php else: ?>
                    <div class="placeholder-image">
                        <i class="fas fa-camera"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-content">
                    <h3><?php echo e($attraction->name); ?></h3>
                    <p class="card-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo e($attraction->location ?? 'Pulau Pramuka'); ?>

                    </p>
                    <p class="card-description"><?php echo e(Str::limit($attraction->description, 100)); ?></p>
                    <div class="card-meta">
                        <span class="meta-item type-badge <?php echo e($attraction->type); ?>">
                            <?php echo e($attraction->formatted_type); ?>

                        </span>
                        <?php if($attraction->average_rating): ?>
                        <span class="meta-rating">
                            <i class="fas fa-star"></i>
                            <?php echo e(number_format($attraction->average_rating, 1)); ?>

                        </span>
                        <?php elseif($attraction->rating_count == 0): ?>
                        <span class="meta-rating">
                            <i class="fas fa-star"></i>
                            N/A
                        </span>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo e(route('tourist-attractions.show', $attraction->id)); ?>" class="card-button">
                        Explore Now
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php else: ?>
    <div class="no-products">
        <i class="fas fa-camera"></i>
        <h3>No tourist attractions available</h3>
        <p>Check back later for amazing attractions!</p>
    </div>
    <?php endif; ?>

    <?php if($touristAttractions->count() > 0): ?>
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?php echo e(route('tourist-attractions.index')); ?>" class="view-all-button">
            <i class="fas fa-map-marked-alt"></i>
            View All Attractions
        </a>
    </div>
    <?php endif; ?>
</section>

<section class="accommodations-section">
    <div class="section-header">
        <i class="fas fa-newspaper icon-circle"></i>
        <h2>Latest News</h2>
    </div>

    <?php if($articles->count() > 0): ?>
    <div class="horizontal-scroll-container">
        <div class="horizontal-scroll-track">
            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="horizontal-feature-card">
                <div class="card-image">
                    <div class="article-badge"><?php echo e($article->capital_category); ?></div>
                    <img src="<?php echo e($article->first_image ? asset('storage/' . $article->first_image) : asset('images/default-article.jpg')); ?>" alt="<?php echo e($article->name); ?>">
                </div>
                <div class="card-content">
                    <h3><?php echo e($article->title); ?></h3>
                    <p class="card-location">
                        <i class="fa-regular fa-calendar fa-xl" style="color: #7f8c8d;"></i>
                        <?php echo e($article->formatted_date); ?>

                    </p>
                    <p class="card-description"><?php echo e(Str::limit($article->content, 200)); ?></p>
                    <a href="<?php echo e(route('articles.show', $article->id)); ?>" class="card-button">
                        Read More
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php else: ?>
    <div class="no-products">
        <i class="fas fa-newspaper"></i>
        <h3>No latest news available</h3>
        <p>Check back later for the latest news!</p>
    </div>
    <?php endif; ?>

    <?php if($articles->count() >= 3): ?>
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?php echo e(route('articles.index')); ?>" class="view-all-button">
            <i class="fas fa-th-large"></i>
            View All News and Articles
        </a>
    </div>
    <?php endif; ?>
</section>


<section class="supported-by-section">
    <h2>Supported by</h2>
    <div class="logos-container">
        <div class="logo-item">
            <img src="<?php echo e(asset('storage/dikti.png')); ?>" alt="DIKTI Logo">
        </div>
        <div class="logo-item">
            <img src="<?php echo e(asset('storage/bima.png')); ?>" alt="BIMA Logo">
        </div>
        <div class="logo-item">
            <img src="<?php echo e(asset('storage/binus.png')); ?>" alt="BINUS University Logo">
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/welcome.blade.php ENDPATH**/ ?>