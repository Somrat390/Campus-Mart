<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus-Mart | University Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <h1 class="text-2xl font-black text-blue-600 tracking-tighter">Campus-Mart</h1>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-blue-600 transition">Log in</a>
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold shadow-md hover:bg-blue-700 transition">Join Now</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-20 text-center">
        <span class="bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-6 inline-block">Exclusive for DIU Students</span>
        <h2 class="text-5xl md:text-7xl font-black mb-8 leading-tight">
            Buy and Sell <br> <span class="text-blue-600">Anything on Campus.</span>
        </h2>
        <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed">
            The safest peer-to-peer marketplace for university students. 
            Trade books, electronics, and essentials with your verified campus peers.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-black text-lg shadow-xl hover:bg-blue-700 transition transform hover:-translate-y-1">
                Start Trading
            </a>
            <a href="#how-it-works" class="bg-white border border-gray-200 text-gray-700 px-10 py-4 rounded-2xl font-bold text-lg hover:bg-gray-50 transition">
                How it works
            </a>
        </div>

        <div class="mt-20 border-8 border-white rounded-3xl shadow-2xl overflow-hidden max-w-5xl mx-auto">
            <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Students collaborating" class="w-full object-cover h-[400px]">
        </div>
    </main>

    <section id="how-it-works" class="bg-white py-20 mt-10">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12">
            <div class="text-left">
                <div class="bg-blue-100 w-12 h-12 rounded-xl flex items-center justify-center text-blue-600 mb-4 font-bold text-xl">1</div>
                <h3 class="font-bold text-xl mb-2">Verified Identity</h3>
                <p class="text-gray-500">Only students with @diu.edu.bd email and a verified ID can trade.</p>
            </div>
            <div class="text-left">
                <div class="bg-blue-100 w-12 h-12 rounded-xl flex items-center justify-center text-blue-600 mb-4 font-bold text-xl">2</div>
                <h3 class="font-bold text-xl mb-2">Safe Exchange</h3>
                <p class="text-gray-500">Meet your buyers and sellers directly on campus. No shipping, no scams.</p>
            </div>
            <div class="text-left">
                <div class="bg-blue-100 w-12 h-12 rounded-xl flex items-center justify-center text-blue-600 mb-4 font-bold text-xl">3</div>
                <h3 class="font-bold text-xl mb-2">Real-time Chat</h3>
                <p class="text-gray-500">Negotiate and set meeting times using our built-in Pusher chat system.</p>
            </div>
        </div>
    </section>

    <footer class="py-10 text-center text-gray-400 text-sm border-t border-gray-100">
        &copy; 2026 Campus-Mart | Designed for Daffodil International University
    </footer>

</body>
</html>