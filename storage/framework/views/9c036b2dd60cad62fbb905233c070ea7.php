<?php $__env->startSection('content'); ?>


<?php if(session('success')): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<?php if($errors->any()): ?>
<div class="alert alert-error">
    <i class="fas fa-exclamation-triangle"></i>
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<style>
    .alert {
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert li {
        margin-bottom: 5px;
    }

    .alert li:last-child {
        margin-bottom: 0;
    }

    .attraction-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: black;
        text-decoration: none;
        margin-bottom: 20px;
        font-weight: 500;
        transition: color 0.3s;
    }

    .back-button:hover {
        color: black;
    }

    .attraction-header {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .attraction-image-main {
        width: 100%;
        height: 400px;
        background-size: cover;
        background-position: center;
        background-color: #f0f0f0;
        position: relative;
    }

    .attraction-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        color: white;
        padding: 30px;
    }

    .attraction-title {
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .attraction-meta {
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 1rem;
    }

    .type-badge {
        background: rgba(0, 123, 255, 0.9);
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .type-badge.tourist_spot {
        background: rgba(40, 167, 69, 0.9);
    }

    .type-badge.restaurant {
        background: rgba(255, 193, 7, 0.9);
        color: #333;
    }

    .type-badge.shop {
        background: rgba(220, 53, 69, 0.9);
    }

    .attraction-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .content-section {
        margin-bottom: 30px;
    }

    .content-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .description-text {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #555;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .info-icon {
        color: #007bff;
        margin-top: 2px;
        width: 20px;
    }

    .info-content h4 {
        margin: 0 0 5px 0;
        font-weight: 600;
        color: #333;
    }

    .info-content p {
        margin: 0;
        color: #666;
    }

    .rating-display {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2rem;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .star {
        color: #ffc107;
    }

    .star.empty {
        color: #ddd;
    }

    .operating-hours {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .hours-list {
        list-style: none;
        padding: 0;
        margin: 10px 0 0 0;
    }

    .hours-list li {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .hours-list li:last-child {
        border-bottom: none;
    }

    .day {
        font-weight: 500;
    }

    .no-info {
        color: #999;
        font-style: italic;
    }

    .image-gallery {
        margin-bottom: 30px;
    }

    .gallery-main-image {
        width: 100%;
        height: 400px;
        background-size: cover;
        background-position: center;
        border-radius: 12px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .gallery-main-image:hover {
        transform: scale(1.02);
    }

    .gallery-thumbnails {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 10px 0;
    }

    .gallery-thumbnail {
        min-width: 80px;
        height: 80px;
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: border-color 0.3s, transform 0.3s;
    }

    .gallery-thumbnail:hover {
        transform: scale(1.05);
    }

    .gallery-thumbnail.active {
        border-color: #007bff;
    }

    .gallery-counter {
        text-align: center;
        color: #666;
        font-size: 0.9rem;
        margin-top: 10px;
    }

    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .lightbox-content {
        position: relative;
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90%;
        top: 50%;
        transform: translateY(-50%);
    }

    .lightbox-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 1001;
    }

    .lightbox-close:hover {
        opacity: 0.7;
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 20px;
        font-size: 20px;
        cursor: pointer;
        z-index: 1001;
    }

    .lightbox-nav:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .lightbox-prev {
        left: 20px;
    }

    .lightbox-next {
        right: 20px;
    }

    @media (max-width: 768px) {
        .attraction-title {
            font-size: 2rem;
        }

        .attraction-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .attraction-content {
            padding: 20px;
        }
    }
</style>

<div class="attraction-detail-container">
    <a href="<?php echo e(route('articles.index')); ?>" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Back to Articles
    </a>

    <div class="attraction-header">
        <div class="attraction-image-main" style="background-image: url('<?php echo e($article->first_image ? asset('storage/' . $article->first_image) : asset('images/default-article.jpg')); ?>')">
            <div class="attraction-overlay">
                <h1 class="attraction-title"><?php echo e($article->capital_title); ?></h1>
                <div class="attraction-meta">
                    <div class="type-badge">
                        <?php echo e($article->capital_category); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="attraction-content">
        <!-- Description Section -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-calendar"></i>
                <?php echo e($article->formatted_date); ?>

            </h2>
            <p class="description-text"><?php echo e($article->content); ?></p>
        </div>

        <!-- Image Gallery Section -->
        <?php if($article->images->count() > 0): ?>
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-images"></i>
                Photo Gallery
            </h2>
            <div class="image-gallery">
                <div class="gallery-main-image" id="mainImage"
                    style="background-image: url('<?php echo e($article->first_image ? asset('storage/' . $article->first_image) : asset('images/default-article.jpg')); ?>')"
                    onclick="openLightbox(0)">
                </div>

                <?php if($article->images->count() > 1): ?>
                <div class="gallery-thumbnails">
                    <?php $__currentLoopData = $article->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="gallery-thumbnail <?php echo e($index === 0 ? 'active' : ''); ?>"
                        style="background-image: url('<?php echo e($image->image_url); ?>')"
                        onclick="changeMainImage('<?php echo e($image->image_url); ?>', <?php echo e($index); ?>)">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <div class="gallery-counter">
                    <span id="imageCounter">1</span> of <?php echo e($article->images->count()); ?> photos
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Comments Section -->
        <div class="content-section">
            <h2 class="section-title">
                <i class="fas fa-comments"></i>
                Comments (<?php echo e($comments->total()); ?>)
            </h2>

            <!-- Comment Form -->
            <?php if(auth()->guard()->check()): ?>
            <div class="comment-form-container">
                <form method="POST" action="<?php echo e(route('articles.comments.store', $article)); ?>" class="comment-form">
                    <?php echo csrf_field(); ?>
                    <div class="comment-form-header">
                        <div class="user-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="user-info">
                            <strong><?php echo e(auth()->user()->name); ?></strong>
                            <span>Write a comment...</span>
                        </div>
                    </div>
                    <textarea 
                        name="content" 
                        placeholder="Share your thoughts about this article..."
                        class="comment-textarea"
                        maxlength="1000"
                        required
                    ><?php echo e(old('content')); ?></textarea>
                    <div class="comment-form-actions">
                        <div class="character-count">
                            <span id="charCount">0</span>/1000
                        </div>
                        <button type="submit" class="comment-submit-btn">
                            <i class="fas fa-paper-plane"></i>
                            Post Comment
                        </button>
                    </div>
                </form>
            </div>
            <?php else: ?>
            <div class="comment-login-prompt">
                <p>
                    <i class="fas fa-sign-in-alt"></i>
                    <a href="<?php echo e(route('login')); ?>">Login</a> to leave a comment
                </p>
            </div>
            <?php endif; ?>

            <!-- Comments List -->
            <div class="comments-list">
                <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="comment-item">
                    <div class="comment-header">
                        <div class="comment-user">
                            <i class="fas fa-user-circle"></i>
                            <div class="comment-user-info">
                                <strong><?php echo e($comment->user->name); ?></strong>
                                <span class="comment-date"><?php echo e($comment->time_ago); ?></span>
                            </div>
                        </div>
                        <?php if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->is_admin)): ?>
                        <div class="comment-actions">
                            <form method="POST" action="<?php echo e(route('articles.comments.destroy', $comment)); ?>" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="comment-delete-btn" 
                                    onclick="return confirm('Are you sure you want to delete this comment?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="comment-content">
                        <?php echo e($comment->content); ?>

                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="no-comments">
                    <i class="fas fa-comments"></i>
                    <p>No comments yet. Be the first to share your thoughts!</p>
                </div>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if($comments->hasPages()): ?>
                <div class="comments-pagination">
                    <?php echo e($comments->withQueryString()->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- Comment Styles -->
<style>
    .comment-form-container {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        border: 1px solid #e5e7eb;
    }

    .comment-form-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .user-avatar {
        font-size: 2rem;
        color: #6b7280;
    }

    .user-info strong {
        display: block;
        color: #1a1a1a;
        font-weight: 600;
    }

    .user-info span {
        color: #6b7280;
        font-size: 0.9rem;
    }

    .comment-textarea {
        width: 100%;
        min-height: 100px;
        max-height: 200px;
        padding: 15px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        line-height: 1.5;
        resize: vertical;
        margin-bottom: 15px;
        font-family: inherit;
        box-sizing: border-box;
    }

    .comment-textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .comment-form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .character-count {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .comment-submit-btn {
        background: #1a1a1a;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .comment-submit-btn:hover {
        background: #374151;
        transform: translateY(-1px);
    }

    .comment-login-prompt {
        text-align: center;
        padding: 40px 20px;
        background: #f9fafb;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .comment-login-prompt i {
        font-size: 2rem;
        color: #d1d5db;
        margin-bottom: 10px;
        display: block;
    }

    .comment-login-prompt a {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 500;
    }

    .comment-login-prompt a:hover {
        text-decoration: underline;
    }

    .comments-list {
        margin-top: 30px;
    }

    .comment-item {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .comment-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .comment-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comment-user i {
        font-size: 1.5rem;
        color: #6b7280;
    }

    .comment-user-info strong {
        display: block;
        color: #1a1a1a;
        font-weight: 600;
    }

    .comment-date {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .comment-actions {
        display: flex;
        gap: 8px;
    }

    .comment-delete-btn {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .comment-delete-btn:hover {
        background: #fee2e2;
    }

    .comment-content {
        color: #374151;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .no-comments {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .no-comments i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #d1d5db;
        display: block;
    }

    .comments-pagination {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .comment-form-container {
            padding: 15px;
        }

        .comment-textarea {
            min-height: 80px;
        }

        .comment-form-actions {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }

        .comment-submit-btn {
            justify-content: center;
        }

        .comment-item {
            padding: 15px;
        }

        .comment-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>

<script>
    // Character counter for comment textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('.comment-textarea');
        const charCount = document.getElementById('charCount');
        
        if (textarea && charCount) {
            function updateCharCount() {
                const currentLength = textarea.value.length;
                charCount.textContent = currentLength;
                
                if (currentLength > 800) {
                    charCount.style.color = '#ef4444';
                } else if (currentLength > 600) {
                    charCount.style.color = '#f59e0b';
                } else {
                    charCount.style.color = '#6b7280';
                }
            }
            
            textarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
        }
    });
</script>

<?php if($article->images->count() > 0): ?>
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <?php if($article->images->count() > 1): ?>
    <button class="lightbox-nav lightbox-prev" onclick="event.stopPropagation(); changeLightboxImage(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="lightbox-nav lightbox-next" onclick="event.stopPropagation(); changeLightboxImage(1)">
        <i class="fas fa-chevron-right"></i>
    </button>
    <?php endif; ?>
    <img class="lightbox-content" id="lightboxImage" onclick="event.stopPropagation()">
</div>

<script>
    const images = <?php echo json_encode($article->images->map(function($image) {
        return $image->image_url;
    }), 15, 512) ?>;

    let currentImageIndex = 0;

    function changeMainImage(imageUrl, index) {
        document.getElementById('mainImage').style.backgroundImage = `url('${imageUrl}')`;
        document.getElementById('imageCounter').textContent = index + 1;
        currentImageIndex = index;

        // Update active thumbnail
        document.querySelectorAll('.gallery-thumbnail').forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
        });
    }

    function openLightbox(index) {
        currentImageIndex = index;
        document.getElementById('lightboxImage').src = images[index];
        document.getElementById('lightbox').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function changeLightboxImage(direction) {
        currentImageIndex += direction;

        if (currentImageIndex >= images.length) {
            currentImageIndex = 0;
        } else if (currentImageIndex < 0) {
            currentImageIndex = images.length - 1;
        }

        document.getElementById('lightboxImage').src = images[currentImageIndex];

        // Update main gallery to match
        changeMainImage(images[currentImageIndex], currentImageIndex);
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (document.getElementById('lightbox').style.display === 'block') {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                changeLightboxImage(-1);
            } else if (e.key === 'ArrowRight') {
                changeLightboxImage(1);
            }
        }
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/articles/show.blade.php ENDPATH**/ ?>