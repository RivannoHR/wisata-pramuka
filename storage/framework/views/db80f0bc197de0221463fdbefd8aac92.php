<?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="attraction-card" onclick="window.location.href='<?php echo e(route('articles.show', $article->id)); ?>'">
    <div class="attraction-image" style="background-image: url('<?php echo e($article->first_image ? asset('storage/' . $article->first_image) : asset('images/default-article.jpg')); ?>')">
        <div class="attraction-type-badge">
            <?php echo e($article->capital_category); ?>

        </div>
    </div>
    <div class="attraction-content">
        <h3 class="attraction-name"><?php echo e($article->title); ?></h3>
        <div class="attraction-location">
            <i class="fas fa-calendar fa-xl""></i>
            <?php echo e($article->formatted_date); ?>

        </div>
        <p class=" attraction-description"><?php echo e($article->content); ?></p>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/articles/partials/attraction-cards.blade.php ENDPATH**/ ?>