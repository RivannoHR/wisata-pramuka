<?php $__env->startSection('title', 'Profile - Pulau Pramuka'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .page-header p {
        font-size: 1.1rem;
        color: #6b7280;
        margin: 0;
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .profile-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #374151 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
        font-weight: 600;
    }

    .profile-name {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .profile-email {
        font-size: 1rem;
        opacity: 0.9;
    }

    .profile-info {
        padding: 30px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .info-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1.1rem;
        color: #1a1a1a;
        font-weight: 500;
    }

    .info-value.empty {
        color: #9ca3af;
        font-style: italic;
    }

    .profile-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: #1a1a1a;
        color: white;
    }

    .btn-primary:hover {
        background: #374151;
        text-decoration: none;
        color: white;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        text-decoration: none;
        color: #374151;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 20px 15px;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .profile-actions {
            flex-direction: column;
        }
    }
</style>

<div class="profile-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>My Profile</h1>
        <p>Manage your account information and preferences</p>
    </div>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

            </div>
            <div class="profile-name"><?php echo e($user->name); ?></div>
            <div class="profile-email"><?php echo e($user->email); ?></div>
        </div>

        <div class="profile-info">
            <!-- Profile Information -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Username</div>
                    <div class="info-value <?php echo e(!$user->username ? 'empty' : ''); ?>">
                        <?php echo e($user->username ?: 'Not set'); ?>

                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Full Name</div>
                    <div class="info-value"><?php echo e($user->name); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email Address</div>
                    <div class="info-value"><?php echo e($user->email); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value <?php echo e(!$user->phone ? 'empty' : ''); ?>">
                        <?php echo e($user->phone ?: 'Not provided'); ?>

                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Address</div>
                    <div class="info-value <?php echo e(!$user->address ? 'empty' : ''); ?>">
                        <?php echo e($user->address ?: 'Not provided'); ?>

                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Member Since</div>
                    <div class="info-value"><?php echo e($user->created_at->format('M d, Y')); ?></div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="profile-actions">
                <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/profile/show.blade.php ENDPATH**/ ?>