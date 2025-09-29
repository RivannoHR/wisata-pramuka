<?php $__env->startSection('title', $attraction->name . ' - Tourist Attractions'); ?>

<?php $__env->startSection('content'); ?>
<style>
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

    /* Tab Navigation */
    .content-tabs {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .tab-navigation {
        display: flex;
        border-bottom: 2px solid #f0f0f0;
    }

    .tab-button {
        flex: 1;
        padding: 20px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: 500;
        color: #666;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
    }

    .tab-button.active {
        color: black;
        border-bottom-color: black;
        background: rgba(0, 0, 0, 0.02);
    }

    .tab-button:hover {
        color: black;
        background: rgba(0, 0, 0, 0.05);
    }

    .tab-content {
        padding: 30px;
    }

    .tab-panel {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .tab-panel.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Content Sections */
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

    /* Reviews Section */
    .reviews-section {
        max-width: 800px;
    }

    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
    }

    .reviews-summary {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .rating-overview {
        text-align: center;
    }

    .rating-score {
        font-size: 2.5rem;
        font-weight: 700;
        color: black;
        line-height: 1;
    }

    .rating-stars {
        color: #ffc107;
        margin: 5px 0;
    }

    .rating-count {
        color: #666;
        font-size: 0.9rem;
    }

    /* Review Form */
    .review-form {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    .rating-input {
        display: flex;
        gap: 5px;
        margin-bottom: 10px;
    }

    .rating-star {
        font-size: 1.5rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }

    .rating-star:hover,
    .rating-star.active {
        color: #ffc107;
    }

    .form-textarea {
        width: 100%;
        min-height: 100px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: inherit;
        resize: vertical;
    }

    .form-textarea:focus {
        outline: none;
        border-color: black;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
    }

    .submit-btn {
        background: black;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background: #333;
    }

    .submit-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* Review Cards */
    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .review-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .review-info h4 {
        margin: 0 0 5px 0;
        font-weight: 600;
        color: #333;
    }

    .review-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #666;
        font-size: 0.9rem;
    }

    .review-rating {
        color: #ffc107;
    }

    .review-text {
        line-height: 1.6;
        color: #555;
    }

    .no-reviews {
        text-align: center;
        padding: 40px;
        color: #666;
    }

    .no-reviews i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #ddd;
    }

    /* Auth Message */
    .auth-message {
        background: #e7f3ff;
        border: 1px solid #b3d9ff;
        color: #0066cc;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }

    .auth-message a {
        color: #0066cc;
        font-weight: 500;
        text-decoration: none;
    }

    .auth-message a:hover {
        text-decoration: underline;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .attraction-detail-container {
            padding: 15px;
        }

        .attraction-title {
            font-size: 2rem;
        }

        .attraction-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .tab-navigation {
            flex-direction: column;
        }

        .tab-button {
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
            border-right: none;
        }

        .tab-button.active {
            border-bottom-color: #f0f0f0;
            border-left: 3px solid black;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .reviews-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .reviewer-avatar {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }
</style>

<div class="attraction-detail-container">
    <a href="<?php echo e(route('tourist-attractions.index')); ?>" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Back to Tourist Attractions
    </a>

    <!-- Attraction Header -->
    <div class="attraction-header">
        <div class="attraction-image-main" style="background-image: url('<?php echo e($attraction->main_image); ?>')">
            <div class="attraction-overlay">
                <h1 class="attraction-title"><?php echo e($attraction->name); ?></h1>
                <div class="attraction-meta">
                    <div class="meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo e($attraction->location); ?>

                    </div>
                    <div class="meta-item">
                        <span class="type-badge <?php echo e($attraction->type); ?>">
                            <?php echo e(ucwords(str_replace('_', ' ', $attraction->type))); ?>

                        </span>
                    </div>
                    <?php if($attraction->average_rating): ?>
                    <div class="meta-item rating-display">
                        <div class="stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star star <?php echo e($i <= $attraction->average_rating ? '' : 'empty'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span><?php echo e(number_format($attraction->average_rating, 1)); ?></span>
                        <span>(<?php echo e($attraction->rating_count); ?> <?php echo e(Str::plural('review', $attraction->rating_count)); ?>)</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Tabs -->
    <div class="content-tabs">
        <nav class="tab-navigation">
            <button class="tab-button active" data-tab="details">
                <i class="fas fa-info-circle"></i>
                Details
            </button>
            <button class="tab-button" data-tab="reviews">
                <i class="fas fa-star"></i>
                Reviews (<?php echo e($reviews->count()); ?>)
            </button>
        </nav>

        <div class="tab-content">
            <!-- Details Panel -->
            <div class="tab-panel active" id="details-panel">
                <div class="content-section">
                    <h2 class="section-title">
                        <i class="fas fa-align-left"></i>
                        About This Place
                    </h2>
                    <p class="description-text"><?php echo e($attraction->description); ?></p>
                </div>

                <?php if($attraction->operating_hours): ?>
                <div class="content-section">
                    <h2 class="section-title">
                        <i class="fas fa-clock"></i>
                        Operating Hours
                    </h2>
                    <div class="operating-hours">
                        <ul class="hours-list">
                            <?php $__currentLoopData = $attraction->operating_hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $hours): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <strong><?php echo e(ucfirst($day)); ?></strong>
                                <span><?php echo e($hours); ?></span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <div class="content-section">
                    <h2 class="section-title">
                        <i class="fas fa-info"></i>
                        Information
                    </h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt info-icon"></i>
                            <div class="info-content">
                                <h4>Location</h4>
                                <p><?php echo e($attraction->location); ?></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-tag info-icon"></i>
                            <div class="info-content">
                                <h4>Type</h4>
                                <p><?php echo e(ucwords(str_replace('_', ' ', $attraction->type))); ?></p>
                            </div>
                        </div>
                        <?php if($attraction->average_rating): ?>
                        <div class="info-item">
                            <i class="fas fa-star info-icon"></i>
                            <div class="info-content">
                                <h4>Rating</h4>
                                <p><?php echo e(number_format($attraction->average_rating, 1)); ?>/5 (<?php echo e($attraction->rating_count); ?> <?php echo e(Str::plural('review', $attraction->rating_count)); ?>)</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Reviews Panel -->
            <div class="tab-panel" id="reviews-panel">
                <div class="reviews-section">
                    <div class="reviews-header">
                        <h2 class="section-title">
                            <i class="fas fa-star"></i>
                            Reviews
                        </h2>
                        <?php if($reviews->count() > 0): ?>
                        <div class="reviews-summary">
                            <div class="rating-overview">
                                <div class="rating-score"><?php echo e(number_format($attraction->average_rating, 1)); ?></div>
                                <div class="rating-stars">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo e($i <= $attraction->average_rating ? '' : 'far'); ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <div class="rating-count"><?php echo e($attraction->rating_count); ?> <?php echo e(Str::plural('review', $attraction->rating_count)); ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                    <!-- Review Form -->
                    <div class="review-form">
                        <h3 style="margin-bottom: 20px;">
                            <?php if($attraction->ratings()->where('user_id', Auth::id())->exists()): ?>
                                Update Your Review
                            <?php else: ?>
                                Write a Review
                            <?php endif; ?>
                        </h3>
                        
                        <form action="<?php echo e(route('tourist-attractions.review.store', $attraction->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label class="form-label">Rating</label>
                                <div class="rating-input">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star rating-star" data-rating="<?php echo e($i); ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <input type="hidden" name="rating" id="rating-value" value="<?php echo e(old('rating', $attraction->ratings()->where('user_id', Auth::id())->first()->rating ?? '')); ?>" required>
                                <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span style="color: red; font-size: 0.9rem;"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="comment">Your Review</label>
                                <textarea 
                                    name="comment" 
                                    id="comment" 
                                    class="form-textarea" 
                                    placeholder="Share your experience about this place..."
                                    required
                                ><?php echo e(old('comment', $attraction->ratings()->where('user_id', Auth::id())->first()->comment ?? '')); ?></textarea>
                                <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span style="color: red; font-size: 0.9rem;"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <button type="submit" class="submit-btn">
                                <?php if($attraction->ratings()->where('user_id', Auth::id())->exists()): ?>
                                    Update Review
                                <?php else: ?>
                                    Post Review
                                <?php endif; ?>
                            </button>
                        </form>
                    </div>
                    <?php else: ?>
                    <div class="auth-message">
                        <p>Please <a href="<?php echo e(route('login')); ?>">login</a> to post a review.</p>
                    </div>
                    <?php endif; ?>

                    <!-- Reviews List -->
                    <?php if($reviews->count() > 0): ?>
                    <div class="reviews-list">
                        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-avatar">
                                    <?php echo e(strtoupper(substr($review->user->name, 0, 1))); ?>

                                </div>
                                <div class="review-info">
                                    <h4><?php echo e($review->user->name); ?></h4>
                                    <div class="review-meta">
                                        <span class="review-rating">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?php echo e($i <= $review->rating ? '' : 'far'); ?>"></i>
                                            <?php endfor; ?>
                                        </span>
                                        <span>•</span>
                                        <span><?php echo e($review->created_at->diffForHumans()); ?></span>
                                    </div>
                                </div>
                            </div>
                            <p class="review-text"><?php echo e($review->comment); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php else: ?>
                    <div class="no-reviews">
                        <i class="fas fa-comment-slash"></i>
                        <h3>No reviews yet</h3>
                        <p>Be the first to share your experience!</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab functionality
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and panels
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
            
            // Add active class to clicked button
            button.classList.add('active');
            
            // Show corresponding panel
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId + '-panel').classList.add('active');
        });
    });

    // Rating input functionality
    document.querySelectorAll('.rating-star').forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = index + 1;
            document.getElementById('rating-value').value = rating;
            
            // Update visual feedback
            document.querySelectorAll('.rating-star').forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });

        star.addEventListener('mouseover', () => {
            const rating = index + 1;
            document.querySelectorAll('.rating-star').forEach((s, i) => {
                if (i < rating) {
                    s.style.color = '#ffc107';
                } else {
                    s.style.color = '#ddd';
                }
            });
        });
    });

    // Reset rating stars on mouse leave
    document.querySelector('.rating-input').addEventListener('mouseleave', () => {
        const currentRating = document.getElementById('rating-value').value;
        document.querySelectorAll('.rating-star').forEach((s, i) => {
            if (i < currentRating) {
                s.style.color = '#ffc107';
                s.classList.add('active');
            } else {
                s.style.color = '#ddd';
                s.classList.remove('active');
            }
        });
    });

    // Set initial rating stars if editing
    window.addEventListener('load', () => {
        const currentRating = document.getElementById('rating-value').value;
        if (currentRating) {
            document.querySelectorAll('.rating-star').forEach((s, i) => {
                if (i < currentRating) {
                    s.classList.add('active');
                }
            });
        }
    });
</script>

<?php if(session('success')): ?>
<script>
    // Show success message
    alert('<?php echo e(session('success')); ?>');
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/tourist-attractions/show.blade.php ENDPATH**/ ?>