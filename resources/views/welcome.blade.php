<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portify - Create Your Professional Portfolio in Minutes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            font-size: 15px;
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .glow {
            box-shadow: 0 0 60px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <nav class="fixed w-full z-50 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold gradient-text">Portify</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-300 hover:text-white transition">Features</a>
                    <a href="#templates" class="text-gray-300 hover:text-white transition">Templates</a>
                    <a href="#pricing" class="text-gray-300 hover:text-white transition">Pricing</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white text-gray-900 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg font-semibold hover:shadow-lg transition">
                            Get Started Free
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 overflow-hidden min-h-screen flex items-center">
        
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gray-900/80 z-10"></div>
            
            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                <source src="{{ asset('videos/bg-fluid.mp4') }}" type="video/mp4">
            </video>
        </div>
        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-black mb-4 leading-tight">
                    Create Your Dream <br>
                    <span class="gradient-text">Portfolio in Minutes</span>
                </h1>
                <p class="text-lg text-gray-300 mb-6 max-w-2xl mx-auto leading-relaxed">
                    Professional portfolio builder with stunning templates. No coding required. 
                    Export to PDF instantly.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @auth
                        <a href="{{ route('templates.index') }}" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-semibold text-base hover:shadow-2xl hover:scale-105 transition glow">
                            Browse Templates →
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl font-semibold text-base hover:shadow-2xl hover:scale-105 transition glow">
                            Start Free Trial →
                        </a>
                        <a href="#templates" class="px-6 py-3 glass rounded-2xl font-semibold text-base hover:bg-white hover:bg-opacity-20 transition">
                            View Templates
                        </a>
                    @endauth
                </div>

                <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-3xl font-bold gradient-text">1000+</p>
                        <p class="text-gray-400 text-sm mt-1">Portfolios Created</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold gradient-text">50+</p>
                        <p class="text-gray-400 text-sm mt-1">Premium Templates</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold gradient-text">5 Min</p>
                        <p class="text-gray-400 text-sm mt-1">Average Build Time</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold gradient-text">4.9★</p>
                        <p class="text-gray-400 text-sm mt-1">User Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-20 relative bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Why Choose <span class="gradient-text">Portify?</span></h2>
                <p class="text-gray-400 text-base">Everything you need to create a stunning portfolio</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass p-6 rounded-3xl card-hover">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Lightning Fast</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Create your portfolio in just 5 minutes. No coding skills required.</p>
                </div>

                <div class="glass p-6 rounded-3xl card-hover">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Beautiful Templates</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Choose from 50+ professionally designed templates.</p>
                </div>

                <div class="glass p-6 rounded-3xl card-hover">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Instant PDF Export</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Download your portfolio as a professional PDF instantly.</p>
                </div>

                <div class="glass p-6 rounded-3xl card-hover">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Secure & Private</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Your data is encrypted and secure. We never share your information.</p>
                </div>

                <div class="glass p-6 rounded-3xl card-hover">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Add Your Projects</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Showcase your work with project galleries and descriptions.</p>
                </div>

                <div class="glass p-6 rounded-3xl card-hover">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Premium Templates</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Upgrade to Pro for access to exclusive premium templates.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="templates" class="py-20 bg-gray-800 bg-opacity-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Stunning <span class="gradient-text">Templates</span></h2>
                <p class="text-gray-400 text-base">Choose from our collection of professionally designed templates</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass rounded-3xl overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                        <span class="text-5xl">📄</span>
                    </div>
                    <div class="p-5">
                        <span class="px-2.5 py-1 bg-green-500 text-xs font-semibold rounded-full">FREE</span>
                        <h3 class="text-lg font-bold mt-2">Modern Minimal</h3>
                        <p class="text-gray-400 text-sm mt-1.5 leading-relaxed">Clean and professional design for developers</p>
                    </div>
                </div>

                <div class="glass rounded-3xl overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center">
                        <span class="text-5xl">✨</span>
                    </div>
                    <div class="p-5">
                        <span class="px-2.5 py-1 bg-purple-500 text-xs font-semibold rounded-full">PRO</span>
                        <h3 class="text-lg font-bold mt-2">Creative Portfolio</h3>
                        <p class="text-gray-400 text-sm mt-1.5 leading-relaxed">Eye-catching design for creative professionals</p>
                    </div>
                </div>

                <div class="glass rounded-3xl overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-pink-600 to-red-600 flex items-center justify-center">
                        <span class="text-5xl">🎨</span>
                    </div>
                    <div class="p-5">
                        <span class="px-2.5 py-1 bg-purple-500 text-xs font-semibold rounded-full">PRO</span>
                        <h3 class="text-lg font-bold mt-2">Designer Showcase</h3>
                        <p class="text-gray-400 text-sm mt-1.5 leading-relaxed">Perfect for showcasing design projects</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('templates.index') }}" class="px-6 py-3 bg-white text-gray-900 rounded-2xl font-semibold hover:bg-gray-100 transition inline-block text-sm">
                    View All Templates →
                </a>
            </div>
        </div>
    </section>

    <section id="pricing" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-3">Simple <span class="gradient-text">Pricing</span></h2>
                <p class="text-gray-400 text-base">Choose the plan that's right for you</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div class="glass p-6 rounded-3xl">
                    <h3 class="text-xl font-bold mb-2">Free</h3>
                    <p class="text-3xl font-bold mb-5">Rp 0<span class="text-base text-gray-400">/forever</span></p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-500 mr-2.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            3 PDF exports per week
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-500 mr-2.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Access to free templates
                        </li>
                        <li class="flex items-center text-sm">
                            <svg class="w-5 h-5 text-green-500 mr-2.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Basic support
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full py-2.5 bg-white text-gray-900 rounded-2xl font-semibold text-sm text-center hover:bg-gray-100 transition">
                        Get Started Free
                    </a>
                </div>

                <div class="glass p-6 rounded-3xl border-2 border-purple-500 relative glow">
                    <span class="absolute -top-3 left-1/2 transform -translate-x-1/2 px-3 py-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full text-xs font-semibold">
                        MOST POPULAR
                    </span>
                    <h3 class="text-xl font-bold mb-2">Pro</h3>
                    <p class="text-3xl font-bold mb-5">Rp 35K<span class="text-base text-gray-400">/month</span></p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <strong>Unlimited</strong>&nbsp;PDF exports
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            All premium templates
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Priority support
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Custom branding
                        </li>
                    </ul>
                    <a href="{{ route('upgrade') }}" class="block w-full py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg font-bold text-center hover:shadow-2xl transition">
                        Upgrade to Pro
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 hero-gradient opacity-10"></div>
        <div class="relative max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Ready to Build Your <span class="gradient-text">Dream Portfolio?</span>
            </h2>
            <p class="text-xl text-gray-400 mb-8">
                Join thousands of professionals who trust Portify
            </p>
            <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg font-bold text-lg hover:shadow-2xl hover:scale-105 transition glow inline-block">
                Start Building Now - It's Free! →
            </a>
        </div>
    </section>

    <footer class="border-t border-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold gradient-text mb-4">Portify</h3>
                    <p class="text-gray-400">Create stunning portfolios in minutes.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#templates" class="hover:text-white transition">Templates</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Portify. All rights reserved. Made with ❤️ in Indonesia</p>
            </div>
        </div>
    </footer>

</body>
</html>