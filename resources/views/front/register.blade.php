@extends('front.layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #7f1d1d;
        --secondary-color: #991b1b;
        --light-bg: #f1f5f9;
        --border-color: #d1d5db;
        --text-muted: #6b7280;
        --success-color: #16a34a;
        --warning-color: #f59e0b;
        --error-color: #dc2626;
        --card-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        --input-bg: #f9fafb;
        --input-focus-bg: #ffffff;
    }

    .register-section {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #ffffff 0%, var(--light-bg) 100%);
        min-height: 100vh;
        flex-direction: column;
        text-align: center;
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 800;
        margin-bottom: 30px;
        font-size: 2.25rem;
        letter-spacing: -0.025em;
        animation: fadeIn 0.8s ease-in;
    }

    .register-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        max-width: 500px;
        width: 100%;
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: slideUp 0.6s ease-out;
    }

    .register-form .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .register-form label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 0.95rem;
        display: block;
        text-align: left;
    }

    .register-form .form-control {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: var(--input-bg);
        height: 42px;
        width: 100%;
    }

    .register-form .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(127, 29, 29, 0.1);
        background: var(--input-focus-bg);
        outline: none;
    }

    .register-form .form-control.is-invalid {
        border-color: var(--error-color);
        background: #fef2f2;
    }

    .register-form .invalid-feedback {
        font-size: 0.85rem;
        color: var(--error-color);
        margin-top: 6px;
        position: absolute;
        text-align: left;
        width: 100%;
    }

    .btn-primary {
        background: var(--primary-color);
        border: none;
        color: #ffffff;
        padding: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        height: 44px;
        position: relative;
    }

    .btn-primary:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(127, 29, 29, 0.2);
    }

    .btn-primary:disabled {
        background: #d1d5db;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-primary .spinner {
        display: none;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        border: 2px solid #ffffff;
        border-top: 2px solid transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .btn-primary.loading .spinner {
        display: block;
    }

    .btn-primary.loading span {
        visibility: hidden;
    }

    .login-link {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s;
    }

    .login-link:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }

    /* Password Strength Indicator */
    .password-strength {
        height: 6px;
        border-radius: 3px;
        margin-top: 8px;
        background: #e5e7eb;
        transition: all 0.3s ease;
    }

    .password-strength.weak {
        width: 33%;
        background: var(--error-color);
    }

    .password-strength.medium {
        width: 66%;
        background: var(--warning-color);
    }

    .password-strength.strong {
        width: 100%;
        background: var(--success-color);
    }

    .password-strength-text {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-top: 6px;
        text-align: left;
    }

    /* Password Toggle Eye */
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50px;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 1.1rem;
        transition: color 0.3s;
    }

    .password-toggle:hover {
        color: var(--primary-color);
    }

    .form-group.password-group {
        position: relative;
    }

    /* File Input Styling */
    .form-control[type="file"] {
        padding: 8px;
        height: auto;
    }

    .form-control[type="file"]::file-selector-button {
        background: var(--primary-color);
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .form-control[type="file"]::file-selector-button:hover {
        background: var(--secondary-color);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes spin {
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .register-section {
            padding: 40px 15px;
        }

        .section-title {
            font-size: 2rem;
        }

        .register-card {
            padding: 20px;
            max-width: 100%;
        }
    }

    @media (max-width: 576px) {
        .section-title {
            font-size: 1.75rem;
        }

        .register-form .form-control {
            font-size: 0.9rem;
            height: 40px;
        }

        .btn-primary {
            font-size: 0.9rem;
            height: 42px;
        }

        .form-group.d-flex {
            flex-direction: column;
            gap: 0;
        }

        .form-group.d-flex .w-50 {
            width: 100% !important;
        }
    }

    /* RTL Support */
    [dir="rtl"] .register-form label,
    [dir="rtl"] .register-form .invalid-feedback,
    [dir="rtl"] .password-strength-text {
        text-align: right;
    }

    [dir="rtl"] .password-toggle {
        right: auto;
        left: 12px;
    }

    [dir="rtl"] .form-group.d-flex {
        flex-direction: row-reverse;
    }
</style>

<body class="bg-light">
    <div class="container register-section" role="main">
        <h2 class="section-title" id="register-title">{{ __('auth.create_account') }}</h2>

        <div class="register-card" role="form" aria-labelledby="register-title">
            <form action="{{ route('client.register.store') }}" method="POST" class="register-form" id="registerForm" enctype="multipart/form-data">
                @csrf

                {{-- Full Name --}}
                <div class="form-group">
                    <label for="name">{{ __('auth.full_name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required placeholder="{{ __('auth.enter_full_name') }}"
                           aria-required="true" aria-describedby="name-error">
                    @error('name')
                        <small class="invalid-feedback" id="name-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">{{ __('auth.email') }} <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required placeholder="{{ __('auth.enter_email') }}"
                           aria-required="true" aria-describedby="email-error">
                    @error('email')
                        <small class="invalid-feedback" id="email-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group password-group">
                    <label for="password">{{ __('auth.password') }} <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                           required placeholder="{{ __('auth.enter_password') }}"
                           aria-required="true" aria-describedby="password-error password-strength-text">
                    <i class="fas fa-eye password-toggle" id="togglePassword" role="button" aria-label="{{ __('auth.toggle_password_visibility') }}"></i>
                    <div class="password-strength" id="passwordStrength"></div>
                    <small class="password-strength-text" id="passwordStrengthText"></small>
                    @error('password')
                        <small class="invalid-feedback" id="password-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group password-group">
                    <label for="password_confirmation">{{ __('auth.confirm_password') }} <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           required placeholder="{{ __('auth.confirm_password') }}"
                           aria-required="true" aria-describedby="password-confirmation-error">
                    <i class="fas fa-eye password-toggle" id="togglePasswordConfirm" role="button" aria-label="{{ __('auth.toggle_password_visibility') }}"></i>
                    @error('password_confirmation')
                        <small class="invalid-feedback" id="password-confirmation-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Phone Number --}}
                <div class="form-group">
                    <label for="phone_number">{{ __('auth.phone_number') }}</label>
                    <input type="tel" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                           value="{{ old('phone_number') }}" placeholder="{{ __('auth.enter_phone_number') }}"
                           aria-describedby="phone-number-error">
                    @error('phone_number')
                        <small class="invalid-feedback" id="phone-number-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Area --}}
                <div class="form-group">
                    <label for="area">{{ __('auth.area') }}</label>
                    <input type="text" name="area" id="area" class="form-control @error('area') is-invalid @enderror"
                           value="{{ old('area') }}" placeholder="{{ __('auth.enter_area') }}"
                           aria-describedby="area-error">
                    @error('area')
                        <small class="invalid-feedback" id="area-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Gender and Date of Birth --}}
                <div class="form-group d-flex gap-3">
                    <div class="w-50">
                        <label for="gender">{{ __('auth.gender') }}</label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror"
                                aria-describedby="gender-error">
                            <option value="">{{ __('auth.select_gender') }}</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('auth.male') }}</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('auth.female') }}</option>
                        </select>
                        @error('gender')
                            <small class="invalid-feedback" id="gender-error">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="w-50">
                        <label for="date_of_birth">{{ __('auth.date_of_birth') }}</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                               value="{{ old('date_of_birth') }}" aria-describedby="date-of-birth-error">
                        @error('date_of_birth')
                            <small class="invalid-feedback" id="date-of-birth-error">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Avatar --}}
                <div class="form-group">
                    <label for="avatar">{{ __('auth.avatar') }}</label>
                    <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror"
                           accept="image/jpeg,image/png,image/gif" aria-describedby="avatar-error">
                    @error('avatar')
                        <small class="invalid-feedback" id="avatar-error">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary" id="registerButton">
                    <span>{{ __('auth.register_now') }}</span>
                    <div class="spinner"></div>
                </button>

                <div class="text-center mt-4">
                    <p class="mb-0">{{ __('auth.already_have_account') }} <a href="{{ route('client.login') }}" class="login-link">{{ __('auth.login_here') }}</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password Toggle Functionality
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const registerButton = document.getElementById('registerButton');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            this.setAttribute('aria-label', type === 'password' ? '{{ __('auth.show_password') }}' : '{{ __('auth.hide_password') }}');
        });

        togglePasswordConfirm.addEventListener('click', function () {
            const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
            passwordConfirmInput.type = type;
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            this.setAttribute('aria-label', type === 'password' ? '{{ __('auth.show_password') }}' : '{{ __('auth.hide_password') }}');
        });

        // Password Strength Indicator
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('passwordStrengthText');

        passwordInput.addEventListener('input', function () {
            const password = this.value;
            let strength = 0;

            if (password.length >= 8) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;

            strengthBar.className = 'password-strength';
            strengthText.textContent = '';

            if (password.length === 0) {
                strengthBar.style.width = '0%';
                return;
            }

            if (strength <= 1) {
                strengthBar.classList.add('weak');
                strengthText.textContent = '{{ __('auth.password_weak') }}';
                strengthText.style.color = 'var(--error-color)';
            } else if (strength <= 3) {
                strengthBar.classList.add('medium');
                strengthText.textContent = '{{ __('auth.password_medium') }}';
                strengthText.style.color = 'var(--warning-color)';
            } else {
                strengthBar.classList.add('strong');
                strengthText.textContent = '{{ __('auth.password_strong') }}';
                strengthText.style.color = 'var(--success-color)';
            }
        });

        // Client-Side Validation
        document.getElementById('registerForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const form = this;
            let isValid = true;

            // Required fields
            const requiredFields = [
                { id: 'name', name: '{{ __('auth.full_name') }}' },
                { id: 'email', name: '{{ __('auth.email') }}' },
                { id: 'password', name: '{{ __('auth.password') }}' },
                { id: 'password_confirmation', name: '{{ __('auth.confirm_password') }}' }
            ];

            requiredFields.forEach(field => {
                const input = form.querySelector(`#${field.id}`);
                const errorElement = form.querySelector(`#${field.id}-error`);

                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    if (!errorElement) {
                        const errorDiv = document.createElement('small');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.id = `${field.id}-error`;
                        errorDiv.textContent = `${field.name} {{ __('auth.is_required') }}`;
                        input.after(errorDiv);
                    }
                } else {
                    input.classList.remove('is-invalid');
                    if (errorElement) errorElement.remove();
                }
            });

            // Password match validation
            const password = passwordInput.value;
            const passwordConfirmation = passwordConfirmInput.value;
            if (password && passwordConfirmation && password !== passwordConfirmation) {
                isValid = false;
                passwordConfirmInput.classList.add('is-invalid');
                let errorElement = form.querySelector('#password-confirmation-error');
                if (!errorElement) {
                    const errorDiv = document.createElement('small');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.id = 'password-confirmation-error';
                    errorDiv.textContent = '{{ __('auth.passwords_do_not_match') }}';
                    passwordConfirmInput.after(errorDiv);
                }
            }

            // Phone number validation (basic format)
            const phoneInput = form.querySelector('#phone_number');
            if (phoneInput.value.trim() && !/^\+?\d{8,15}$/.test(phoneInput.value.trim())) {
                isValid = false;
                phoneInput.classList.add('is-invalid');
                let errorElement = form.querySelector('#phone-number-error');
                if (!errorElement) {
                    const errorDiv = document.createElement('small');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.id = 'phone-number-error';
                    errorDiv.textContent = '{{ __('auth.invalid_phone_number') }}';
                    phoneInput.after(errorDiv);
                }
            }

            // Avatar file type validation
            const avatarInput = form.querySelector('#avatar');
            if (avatarInput.files.length > 0) {
                const file = avatarInput.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    isValid = false;
                    avatarInput.classList.add('is-invalid');
                    let errorElement = form.querySelector('#avatar-error');
                    if (!errorElement) {
                        const errorDiv = document.createElement('small');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.id = 'avatar-error';
                        errorDiv.textContent = '{{ __('auth.invalid_file_type') }}';
                        avatarInput.after(errorDiv);
                    }
                }
            }

            if (isValid) {
                registerButton.disabled = true;
                registerButton.classList.add('loading');
                form.submit();
            } else {
                alert('{{ __('auth.please_fix_errors') }}');
            }
        });
    </script>
</body>
@endsection
