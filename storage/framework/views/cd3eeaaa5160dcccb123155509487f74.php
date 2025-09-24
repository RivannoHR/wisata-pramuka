<?php $__currentLoopData = $accommodations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accommodation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="accommodation-card" onclick="window.location.href='<?php echo e(route('accommodations.show', $accommodation->id)); ?>'">
    <div class="accommodation-image" style="background-image: url('<?php echo e($accommodation->main_image); ?>')">
        <?php if($accommodation->average_rating_from_reviews): ?>
        <div class="rating-overlay">
            <i class="fas fa-star star"></i>
            <?php echo e(number_format($accommodation->average_rating_from_reviews, 1)); ?>

        </div>
        <?php else: ?>
        <div class="rating-overlay">
            <i class="fas fa-star star"></i>
            N/A
        </div>
        <?php endif; ?>
    </div>

    <div class="accommodation-content">
        <div class="accommodation-header">
            <h3 class="accommodation-name"><?php echo e($accommodation->name); ?></h3>
            <?php if($accommodation->location): ?>
            <div class="accommodation-location">
                <i class="fas fa-map-marker-alt"></i>
                <?php echo e($accommodation->location); ?>

            </div>
            <?php endif; ?>
            <div class="accommodation-type"><?php echo e($accommodation->formatted_type); ?></div>
        </div>

        <p class="accommodation-description"><?php echo e($accommodation->description); ?></p>

        <?php if($accommodation->facilities && count($accommodation->facilities) > 0): ?>
        <div class="accommodation-facilities">
            <div class="facilities-list">
                <?php $__currentLoopData = array_slice($accommodation->facilities, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="facility-item">
                    <i class="fas fa-check"></i>
                    <?php echo e(ucfirst($facility)); ?>

                </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(count($accommodation->facilities) > 4): ?>
                <span class="facility-item">
                    +<?php echo e(count($accommodation->facilities) - 4); ?> more
                </span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="accommodation-footer">
            <div class="price-section">
                <div class="price-label">Starting from</div>
                <div class="price-value">
                    Rp <?php echo e(number_format($accommodation->price, 0, ',', '.')); ?>

                    <span class="price-unit">/night</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/accommodations/partials/accommodation-cards.blade.php ENDPATH**/ ?>