
    <style>
        /* Base Styles */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        /* Main Container */
        .login-container {
            
            min-height: 100vh;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-sizing: border-box;
        }
        
        /* Card Styles */
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            max-height: 90vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        /* Header Styles */
        .login-header {
            background: #f59e0b; /* Warna amber */
            color: white;
            padding: 2rem;
            text-align: center;
            flex-shrink: 0;
        }
        
        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            opacity: 0.9;
            font-size: 0.9rem;
            margin: 0;
        }
        
        /* Form Container */
        .form-container {
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        /* Form Elements */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-field {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f8fafc;
            box-sizing: border-box;
        }
        
        .input-field:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
            background-color: white;
            outline: none;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: color 0.3s;
        }
        
        .input-group:focus-within .input-icon {
            color: #f59e0b;
        }
        
        /* Remember Me & Forgot Password */
        .remember-forgot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .remember-me input {
            width: 18px;
            height: 18px;
            accent-color: #f59e0b;
            margin-right: 8px;
        }
        
        .remember-me span {
            font-size: 0.9rem;
            color: #64748b;
        }
        
        .forgot-password {
            font-size: 0.9rem;
            color: #d97706;
            text-decoration: none;
            transition: color 0.3s;
            margin-bottom: 0.5rem;
        }
        
        .forgot-password:hover {
            color: #b45309;
        }
        
        /* Submit Button */
        .login-btn {
            width: 100%;
            padding: 15px;
            background: #f59e0b;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            flex-shrink: 0;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.15);
            background: #d97706;
        }
        
        /* Footer */
        .login-footer {
            padding: 1.5rem;
            text-align: center;
            background-color: #f8fafc;
            font-size: 0.9rem;
            color: #64748b;
            flex-shrink: 0;
            border-top: 1px solid #e2e8f0;
        }
        
        .login-footer a {
            color: #d97706;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .login-footer a:hover {
            color: #b45309;
        }
        
        /* Error Messages */
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
        }
        
        /* Responsive Adjustments */
        @media (max-height: 600px) {
            .login-card {
                max-height: 95vh;
            }
            
            .login-header {
                padding: 1.5rem;
            }
            
            .form-container {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="form-container" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="form-container">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                           class="input-field" placeholder="Email Address">
                    <x-input-error :messages="$errors->get('email')" class="error-message" />
                </div>

                <!-- Password -->
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input id="password" type="password" name="password" required 
                           class="input-field" placeholder="Password">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                    <x-input-error :messages="$errors->get('password')" class="error-message" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="remember-forgot">
                    <label class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-btn">
                    Log in
                </button>
            </form>

            <!-- Footer -->
            <!-- <div class="login-footer">
                Don't have an account? 
                <a href="{{ route('register') }}">Sign up</a>
            </div> -->
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

    <!-- Load Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
