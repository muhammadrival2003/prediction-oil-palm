<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PTPN IV Oil Palm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #059669 25%, #047857 50%, #065f46 75%, #064e3b 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .floating-animation {
            animation: floating 6s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.15);
        }
        
        .btn-hover {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-hover:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-hover:hover:before {
            left: 100%;
        }
        
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
        
        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            80%, 100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }
        
        .loading-spinner {
            display: none;
        }
        
        .loading .loading-spinner {
            display: inline-block;
        }
        
        .loading .btn-text {
            display: none;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-5 rounded-full floating-animation"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white opacity-10 rounded-full floating-animation" style="animation-delay: -1s;"></div>
    </div>
    <!-- Main Login Card -->
    <div class="w-full max-w-md glass-card rounded-2xl shadow-2xl overflow-hidden transition-all duration-500 hover:shadow-3xl hover:scale-105 relative z-10">
        <!-- Header with Logo -->
        <div class="relative bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 text-white p-8 text-center overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full translate-y-12 -translate-x-12"></div>
            
            <!-- Logo/Icon -->
            <div class="relative z-10 mb-4">
                <!-- <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 pulse-ring">
                    <i class="fas fa-seedling text-2xl text-white"></i>
                </div> -->
                <h1 class="text-3xl font-bold tracking-tight">Selamat Datang</h1>
                <p class="opacity-90 mt-2 font-medium">PTPN IV Oil Palm Prediction</p>
                <div class="w-16 h-1 bg-white bg-opacity-30 rounded-full mx-auto mt-4"></div>
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="p-6" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="p-8 space-y-6" id="loginForm">
            @csrf

            <!-- Welcome Message -->
            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Masuk ke Akun Anda</h2>
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                        <i class="fas fa-envelope text-lg"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input-focus w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-gray-800 placeholder-gray-400"
                           placeholder="Masukkan email Anda">
                    <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-emerald-500 to-emerald-600 transform scale-x-0 group-focus-within:scale-x-100 transition-transform duration-300"></div>
                </div>
                <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm flex items-center mt-2" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                        <i class="fas fa-lock text-lg"></i>
                    </div>
                    <input id="password" type="password" name="password" required
                           class="input-focus w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-300 text-gray-800 placeholder-gray-400"
                           placeholder="Masukkan password Anda">
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 transition-colors duration-200">
                        <i class="fas fa-eye text-lg" id="toggleIcon"></i>
                    </button>
                    <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-emerald-500 to-emerald-600 transform scale-x-0 group-focus-within:scale-x-100 transition-transform duration-300"></div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm flex items-center mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                    <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium transition-colors duration-200 hover:underline">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-hover w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transform hover:scale-105 shadow-lg hover:shadow-xl" id="submitBtn">
                <span class="btn-text flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk ke Dashboard
                </span>
                <span class="loading-spinner">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Memproses...
                </span>
            </button>
        </form>

        <!-- Security Notice -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200 p-6 text-center">
            <div class="flex items-center justify-center text-gray-600 text-sm">
                <i class="fas fa-shield-alt text-emerald-500 mr-2"></i>
                <span>Koneksi Anda aman dan terenkripsi</span>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Re-enable button after 5 seconds as fallback
            setTimeout(() => {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }, 5000);
        });

        // Input validation and styling
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            
            inputs.forEach(input => {
                // Add focus and blur effects
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                    
                    // Basic validation styling
                    if (this.value.trim() === '') {
                        this.classList.add('border-red-300');
                        this.classList.remove('border-emerald-500');
                    } else {
                        this.classList.remove('border-red-300');
                        this.classList.add('border-emerald-300');
                    }
                });

                // Real-time validation for email
                if (input.type === 'email') {
                    input.addEventListener('input', function() {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (this.value && !emailRegex.test(this.value)) {
                            this.classList.add('border-yellow-300');
                            this.classList.remove('border-emerald-300', 'border-red-300');
                        } else if (this.value) {
                            this.classList.add('border-emerald-300');
                            this.classList.remove('border-yellow-300', 'border-red-300');
                        }
                    });
                }
            });

            // Add smooth entrance animation
            const loginCard = document.querySelector('.glass-card');
            loginCard.style.opacity = '0';
            loginCard.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                loginCard.style.transition = 'all 0.6s ease-out';
                loginCard.style.opacity = '1';
                loginCard.style.transform = 'translateY(0)';
            }, 100);
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const focusedElement = document.activeElement;
                if (focusedElement.id === 'email') {
                    document.getElementById('password').focus();
                    e.preventDefault();
                } else if (focusedElement.id === 'password') {
                    document.getElementById('loginForm').submit();
                }
            }
        });

        // Add particle effect on hover (optional enhancement)
        const loginCard = document.querySelector('.glass-card');
        loginCard.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02) translateY(-5px)';
        });
        
        loginCard.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) translateY(0)';
        });
    </script>
</body>
</html>