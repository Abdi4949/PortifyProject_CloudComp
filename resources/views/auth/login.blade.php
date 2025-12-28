<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Portify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        * { font-family: 'Inter', sans-serif; }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center p-4">
    
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-pink-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    </div>

    <div class="relative w-full max-w-md">
        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-bold gradient-text">Portify</a>
            <p class="text-gray-400 mt-2">Welcome back! Please login to your account.</p>
        </div>

        <div class="glass rounded-2xl p-8">
            <h2 class="text-2xl font-bold mb-6">Login</h2>

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-500 bg-opacity-20 border border-green-500 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-500 rounded-lg text-sm text-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium mb-2">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-purple-500 transition"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 border-gray-700 bg-gray-800 rounded focus:ring-purple-500"
                        >
                        <span class="ml-2 text-sm text-gray-400">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-purple-400 hover:text-purple-300">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg font-bold hover:shadow-2xl transition"
                >
                    Login
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-gray-900 text-gray-400">Or continue with</span>
                </div>
            </div>

            <div class="mb-6">
                <a href="{{ route('google.login') }}" class="flex items-center justify-center w-full py-3 bg-white text-gray-900 rounded-lg font-bold hover:bg-gray-100 transition duration-200">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </a>
            </div>

            <p class="text-center text-sm text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 font-semibold">
                    Sign up for free
                </a>
            </p>
        </div>

        <div class="text-center mt-6">
            <a href="/" class="text-sm text-gray-400 hover:text-white transition">
                ← Back to Home
            </a>
        </div>
    </div>

</body>
</html>