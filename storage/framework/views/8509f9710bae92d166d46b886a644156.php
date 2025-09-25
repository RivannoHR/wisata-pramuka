<?php $__currentLoopData = $attractions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attraction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="attraction-card" onclick="window.location.href='<?php echo e(route('tourist-attractions.show', $attraction->id)); ?>'">
        <div class="attraction-image" style="background-image: url('<?php echo e($attraction->main_image); ?>')">
            <div class="attraction-type-badge <?php echo e($attraction->type); ?>">
                <?php echo e($attraction->formatted_type); ?>

            </div>
            <?php if($attraction->average_rating): ?>
                <div class="attraction-rating">
                    <i class="fas fa-star"></i>
                    <?php echo e(number_format($attraction->average_rating, 1)); ?>

                </div>
            <?php elseif($attraction->rating_count == 0): ?>
                <div class="attraction-rating">
                    <i class="fas fa-star"></i>
                    N/A
                </div>
            <?php endif; ?>
        </div>
        <div class="attraction-content">
            <h3 class="attraction-name"><?php echo e($attraction->name); ?></h3>
            <?php if($attraction->location): ?>
                <div class="attraction-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php echo e($attraction->location); ?>

                </div>
            <?php endif; ?>
            <p class="attraction-description"><?php echo e($attraction->description); ?></p>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/tourist-attractions/partials/attraction-cards.blade.php ENDPATH**/ ?>