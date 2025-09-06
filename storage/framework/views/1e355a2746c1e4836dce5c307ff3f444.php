<?php $__env->startSection('title', 'Login'); ?>
<?php $__env->startSection('content'); ?>

    <div class="login-wrapper login-new">
        <div class="row w-100 min-vh-100 d-flex align-items-center justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="login-content user-login">
                    <div class="login-logo text-center mb-4">
                        <img src="<?php echo e(asset('assets/img/ryofin-logo.png')); ?>" alt="img" class="img-fluid"
                            style="max-height: 80px;">
                        <a href="<?php echo e(url('/')); ?>" class="login-logo logo-white d-none">
                            <img src="<?php echo e(asset('assets/img/ryofin-logo.png')); ?>" alt="Img" class="img-fluid">
                        </a>
                    </div>
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="card shadow-sm">
                            <div class="card-body p-4 p-sm-5">
                                <div class="login-userheading text-center mb-4">
                                    <h3 class="fw-bold">Sign In</h3>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="phone" value="<?php echo e(old('phone')); ?>"
                                            class="form-control border-end-0 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
                                            autocomplete="phone" autofocus placeholder="Enter your phone number">
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-phone"></i>
                                        </span>
                                    </div>
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="pass-group">
                                        <input type="password" name="password" id="password"
                                            class="pass-input form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required
                                            autocomplete="current-password" placeholder="Enter your password">
                                        <span class="ti toggle-password ti-eye-off text-gray-9"
                                            onclick="togglePasswordVisibility('password', this)"></span>
                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-login authentication-check mb-3">
                                    <div class="row">
                                        <div
                                            class="col-12 d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2">
                                            <div class="custom-control custom-checkbox">
                                                <label class="checkboxs ps-4 mb-0 pb-0 line-height-1 fs-16 text-gray-6">
                                                    <input type="checkbox" class="form-control" name="remember"
                                                        id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                                    <span class="checkmarks"></span>Remember me
                                                </label>
                                            </div>
                                            <div class="text-start text-sm-end">
                                                <?php if(Route::has('password.reset.request')): ?>
                                                    <a class="text-orange fs-16 fw-medium"
                                                        href="<?php echo e(route('password.reset.request')); ?>">Forgot Password?</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-login mb-3">
                                    <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>
                                </div>
                                <div class="signinform text-center">
                                    <h4 class="mb-0">Don't have account?
                                        <a href="<?php echo e(route('register')); ?>" class="hover-a text-primary"> Create an
                                            account</a>
                                    </h4>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, icon) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            }
        }
    </script>

    <style>
        @media (max-width: 576px) {
            .login-wrapper {
                padding: 1rem;
            }

            .card-body {
                padding: 1.5rem !important;
            }

            .login-userheading h3 {
                font-size: 1.5rem;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .signinform h4 {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 375px) {
            .login-wrapper {
                padding: 0.5rem;
            }

            .card-body {
                padding: 1rem !important;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /workspace/Double-Entry-Accounting-System/resources/views/auth/login.blade.php ENDPATH**/ ?>