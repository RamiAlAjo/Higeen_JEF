@extends('front.layouts.app')

@section('content')

<style>
    /* Same styles as before */
    .login-section {
        padding: 50px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .section-title {
        color: #8b3a2b;
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 2rem;
        text-align: center;
        animation: fadeIn 0.5s ease-in;
    }

    .login-card {
        background: #fff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: slideUp 0.6s ease-out;
        max-width: 500px;
        margin: 0 auto;
    }

    .login-form .form-control {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 12px;
        font-size: 0.95rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .login-form .form-control:focus {
        border-color: #8b3a2b;
        box-shadow: 0 0 8px rgba(139, 58, 43, 0.2);
    }

    .login-form label {
        font-weight: 600;
        color: #2e3a59;
        margin-bottom: 10px;
    }

    .login-form .form-group {
        margin-bottom: 25px;
    }

    .btn-primary {
        background: #8b3a2b;
        border-color: #8b3a2b;
        color: #fff;
        padding: 12px 30px;
        font-size: 1rem;
        border-radius: 6px;
        transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
        width: 100%;
    }

    .btn-primary:hover {
        background: #2e3a59;
        border-color: #2e3a59;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .register-link {
        color: #8b3a2b;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s;
    }

    .register-link:hover {
        color: #2e3a59;
        text-decoration: underline;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @media (max-width: 576px) {
        .login-section {
            padding: 30px 0;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .login-card {
            padding: 15px;
        }
    }
</style>

<body class="bg-light">
    <div class="container login-section">
        <h2 class="section-title">Login</h2>

        <div class="login-card">
            <form action="{{ route('client.login.store') }}" method="POST" class="login-form" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="{{ old('email') }}" required placeholder="Enter your email" aria-required="true">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control"
                           required placeholder="Enter your password" aria-required="true">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>

                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="{{ route('client.register') }}" class="register-link">Register here</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Client-Side Validation (unchanged)
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const form = this;
            let isValid = true;
            const requiredFields = ['email', 'password'];

            requiredFields.forEach(field => {
                const input = form.querySelector(`#${field}`);
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                    const error = input.nextElementSibling;
                    if (error && error.classList.contains('text-danger')) {
                        error.textContent = `${input.name.replace(/^./, str => str.toUpperCase())} is required.`;
                    } else {
                        const errorDiv = document.createElement('small');
                        errorDiv.className = 'text-danger';
                        errorDiv.textContent = `${input.name.replace(/^./, str => str.toUpperCase())} is required.`;
                        input.after(errorDiv);
                    }
                } else {
                    input.classList.remove('is-invalid');
                    const error = input.nextElementSibling;
                    if (error && error.classList.contains('text-danger')) {
                        error.remove();
                    }
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    </script>
</body>

@endsection
