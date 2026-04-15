<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus-Mart | The Universal University Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.1), transparent),
                        radial-gradient(circle at bottom left, rgba(147, 51, 234, 0.05), transparent);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 hero-gradient">

    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto relative z-50">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                <span class="text-white font-black text-xl">C</span>
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-800">Campus<span class="text-blue-600">Mart</span></h1>
        </div>
        <div class="hidden md:flex items-center gap-8 font-semibold text-slate-600">
            <a href="#features" class="hover:text-blue-600 transition">Features</a>
            <a href="{{ route('login') }}" class="hover:text-blue-600 transition">Login</a>
            <a href="{{ route('register') }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl hover:bg-slate-800 transition shadow-xl">Start Selling</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 pt-16 pb-24 text-center">
        <div data-aos="fade-up">
            <span class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider mb-8 border border-blue-100">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                Live across all Universities
            </span>
            <h2 class="text-5xl md:text-8xl font-black mb-8 leading-[1.1] tracking-tight text-slate-900">
                Your Campus. <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Your Marketplace.</span>
            </h2>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto mb-12 leading-relaxed">
                The most trusted re-commerce platform for students. Buy, sell, and trade essentials with verified peers from your own university.
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row justify-center gap-5" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('register') }}" class="group relative bg-blue-600 text-white px-10 py-5 rounded-2xl font-bold text-lg shadow-2xl shadow-blue-200 hover:bg-blue-700 transition-all hover:scale-105 active:scale-95">
                Get Started Now
                <span class="inline-block ml-2 transition-transform group-hover:translate-x-1">→</span>
            </a>
            <a href="{{ route('login') }}" class="bg-white border border-slate-200 text-slate-700 px-10 py-5 rounded-2xl font-bold text-lg hover:bg-slate-50 transition shadow-sm">
                Browse Items
            </a>
        </div>

        <div class="mt-24 relative" data-aos="zoom-in-up" data-aos-delay="400">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse delay-700"></div>
            
            <div class="relative bg-white p-3 rounded-[2.5rem] shadow-2xl border border-slate-100 inline-block overflow-hidden transition-transform hover:scale-[1.01]">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80" alt="Students in campus" class="rounded-[2rem] w-full max-w-5xl h-[500px] object-cover">
                <div class="absolute bottom-10 left-10 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/50 text-left animate-bounce hidden md:block">
                    <p class="text-xs font-bold text-blue-600 uppercase">New Listing</p>
                    <p class="font-bold">Calculus Textbook • $20</p>
                </div>
            </div>
        </div>
    </main>

    <section id="features" class="py-32 bg-slate-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <h3 class="text-3xl md:text-5xl font-black mb-4">Built for Student Safety</h3>
                <p class="text-slate-400">Security features that make campus trading worry-free.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-slate-800/50 p-10 rounded-[2rem] border border-slate-700 hover:border-blue-500 transition-all group" data-aos="fade-up">
                    <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-12 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Multi-University Support</h4>
                    <p class="text-slate-400 leading-relaxed">Simply select your university during signup. The marketplace automatically filters items from your own campus peers.</p>
                </div>
                <div class="bg-slate-800/50 p-10 rounded-[2rem] border border-slate-700 hover:border-blue-500 transition-all group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-12 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Pusher Real-time Chat</h4>
                    <p class="text-slate-400 leading-relaxed">Chat instantly with sellers. No need to share personal numbers. Finalize deals via our high-speed, secure messaging system.</p>
                </div>
                <div class="bg-slate-800/50 p-10 rounded-[2rem] border border-slate-700 hover:border-blue-500 transition-all group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-12 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 012-2V6a2 2 0 01-2-2H6a2 2 0 01-2 2v12a2 2 0 012 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-3">Cloudinary Optimized</h4>
                    <p class="text-slate-400 leading-relaxed">Lightning-fast image loading for product ads and ID verification. Your media is always accessible, high-quality, and secure.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 text-center text-slate-400 text-sm">
        <div class="flex items-center justify-center gap-2 mb-4">
            <div class="w-6 h-6 bg-blue-600 rounded flex items-center justify-center text-[10px] text-white font-bold uppercase">CM</div>
            <p class="font-bold text-slate-800">Campus-Mart</p>
        </div>
        &copy; 2026 Campus-Mart Platform. Empowering students across all universities.
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>
</body>
</html>