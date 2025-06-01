<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden transition-all hover:shadow-xl">
        <!-- Header -->
        <div class="bg-emerald-500 text-white p-8 text-center">
            <h1 class="text-2xl font-bold">Selamat Datang</h1>
            <p class="opacity-90 mt-1">PTPN IV Oil Palm</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="p-6" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="p-6 space-y-6">
            @csrf

            <!-- Email -->
            <div class="space-y-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus
                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="Email Address">
                </div>
                <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input id="password" type="password" name="password" required
                           class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                           placeholder="Password">
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex flex-col sm:flex-row justify-between items-center">

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-emerald-600 hover:text-emerald-700 mt-2 sm:mt-0">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-3 px-4 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Log in
            </button>
        </form>

        <!-- Footer -->
        <!-- <div class="bg-gray-50 border-t border-gray-200 p-4 text-center text-gray-600 text-sm">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Sign up</a>
        </div> -->
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('#password + button i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>