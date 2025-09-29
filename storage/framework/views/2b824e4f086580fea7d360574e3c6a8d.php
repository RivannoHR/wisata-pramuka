<?php $__env->startSection('content'); ?>
<style>
    .error-message {
        color: #e3342f;
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: block;
    }

    .help-text {
        font-size: 12px;
        color: #666;
        margin-top: 0.25rem;
        display: block;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
        font-family: inherit;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-error {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
</style>

<div class="login-container">
    <div class="login-box">
        <h2>What are you waiting for?</h2>
        <p>Start your tropical journey now.</p>
        
        <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <strong>Please correct the following errors:</strong>
            <ul style="margin: 8px 0 0 20px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo e(route('register')); ?>" class="login-form">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <input type="text" 
                       id="name"
                       name="name" 
                       placeholder="Full Name" 
                       value="<?php echo e(old('name')); ?>"
                       required>
                <?php if($errors->has('name')): ?>
                    <span class="error-message"><?php echo e($errors->first('name')); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="email" 
                       name="email" 
                       placeholder="Email" 
                       value="<?php echo e(old('email')); ?>"
                       required>
                <?php if($errors->has('email')): ?>
                    <span class="error-message"><?php echo e($errors->first('email')); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="tel" 
                       id="phone"
                       name="phone" 
                       placeholder="Phone Number" 
                       value="<?php echo e(old('phone')); ?>"
                       required>
                <?php if($errors->has('phone')): ?>
                    <span class="error-message"><?php echo e($errors->first('phone')); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <input type="password" 
                       name="password" 
                       placeholder="Password" 
                       required>
                <?php if($errors->has('password')): ?>
                    <span class="error-message"><?php echo e($errors->first('password')); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="password" 
                       name="password_confirmation" 
                       placeholder="Confirm Password" 
                       required>
            </div>
            
            <button type="submit" class="login-button">Register</button>
        </form>
        
        <div class="register-link">
            Already have an account? <a href="<?php echo e(route('login')); ?>">Login here</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const phoneInput = document.getElementById('phone');

    // Real-time validation for name (alphabetic only) - non-blocking
    nameInput.addEventListener('input', function(e) {
        const value = e.target.value;
        const alphabeticOnly = /^[a-zA-Z\s]*$/;
        
        if (!alphabeticOnly.test(value)) {
            e.target.style.borderColor = '#dc3545';
        } else {
            e.target.style.borderColor = value ? '#28a745' : '';
        }
    });

    // Real-time validation for phone (+62 format) - non-blocking
    phoneInput.addEventListener('input', function(e) {
        const value = e.target.value;
        const phonePattern = /^\+62[0-9]{8,13}$/;
        
        if (value && !phonePattern.test(value)) {
            e.target.style.borderColor = '#dc3545';
        } else {
            e.target.style.borderColor = value ? '#28a745' : '';
        }
    });

    // Auto-format phone number
    phoneInput.addEventListener('focus', function(e) {
        if (!e.target.value) {
            e.target.value = '+62';
        }
    });
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/auth/register.blade.php ENDPATH**/ ?>