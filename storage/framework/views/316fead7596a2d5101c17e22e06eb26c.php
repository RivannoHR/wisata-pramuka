<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Inter', sans-serif;
            color: #333;

        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('');
            background-size: cover;
            background-position: center;
            padding: 20px;

        }

        .login-container h2 {
            text-align: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-box h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .login-box p {
            color: #666;
            margin-bottom: 30px;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .login-form input:focus {
            outline: none;
            border-color: black;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #ddd;
            color: #666;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-sizing: border-box;
        }

        .login-button:hover {
            background: black;
            color: #fff;
        }

        /* Error and Success Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-error {
            background-color: #fee;
            border: 1px solid #fcc;
            color: #c53030;
        }

        .alert-info {
            background-color: #e6f3ff;
            border: 1px solid #b3d9ff;
            color: #2563eb;
        }

        .field-error {
            color: #c53030;
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .login-form input.error {
            border-color: #c53030;
            background-color: #fef2f2;
        }

        .login-form input.error:focus {
            border-color: #c53030;
            box-shadow: 0 0 0 3px rgba(197, 48, 48, 0.1);
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle .toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 14px;
        }

        .password-toggle .toggle-btn:hover {
            color: #333;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .login-button.loading {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>

</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login Page Admin</h2>
            <br>

            <!-- Display general error messages -->
            <?php if($errors->any()): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <?php if($errors->has('email')): ?>
                            <?php echo e($errors->first('email')); ?>

                        <?php elseif($errors->has('password')): ?>
                            <?php echo e($errors->first('password')); ?>

                        <?php else: ?>
                            <?php echo e($errors->first()); ?>

                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Display success messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Display logout message -->
            <?php if(session('status')): ?>
                <div class="alert alert-info">
                    <i class="fas fa-check-circle"></i>
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.login.post')); ?>" class="login-form" id="loginForm">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <input type="email" 
                           name="email" 
                           placeholder="Email Address" 
                           value="<?php echo e(old('email')); ?>" 
                           class="<?php echo e($errors->has('email') ? 'error' : ''); ?>"
                           required
                           autocomplete="email"
                           autofocus>
                    <?php if($errors->has('email')): ?>
                        <div class="field-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo e($errors->first('email')); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <div class="password-toggle">
                        <input type="password" 
                               name="password" 
                               placeholder="Password" 
                               class="<?php echo e($errors->has('password') ? 'error' : ''); ?>"
                               id="passwordField"
                               required
                               autocomplete="current-password">
                        <button type="button" class="toggle-btn" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    <?php if($errors->has('password')): ?>
                        <div class="field-error">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo e($errors->first('password')); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="login-button" id="loginBtn">
                    <span id="btnText">Log In</span>
                    <i class="fas fa-spinner fa-spin" id="loadingSpinner" style="display: none;"></i>
                </button>
            </form>

        
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('passwordField');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        // Add loading state to form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const form = this;
            const loginBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            
            // Basic validation
            const email = form.email.value.trim();
            const password = form.password.value.trim();
            
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in both email and password fields.');
                return;
            }
            
            if (!isValidEmail(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                return;
            }
            
            // Show loading state
            loginBtn.classList.add('loading');
            btnText.style.display = 'none';
            loadingSpinner.style.display = 'inline-block';
            loginBtn.disabled = true;
            
            // Re-enable button after 10 seconds (in case of network issues)
            setTimeout(() => {
                loginBtn.classList.remove('loading');
                btnText.style.display = 'inline-block';
                loadingSpinner.style.display = 'none';
                loginBtn.disabled = false;
            }, 10000);
        });

        function isValidEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

        // Clear error styling when user starts typing
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const errorDiv = this.parentNode.querySelector('.field-error');
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                }
            });
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            });
        }, 5000);
    </script>
</body>

</html><?php /**PATH /Users/nathanaelss/Downloads/wisata-pramuka-minimal/resources/views/admin/login.blade.php ENDPATH**/ ?>