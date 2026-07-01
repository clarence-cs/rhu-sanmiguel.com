<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RHU San Miguel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="antialiased text-gray-800 font-sans">

    <div class="relative min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/rhu-bg.png') }}');">
        
        <div class="absolute inset-0 bg-teal-950/80 mix-blend-multiply"></div>

        <nav class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 py-4 lg:px-12 text-white bg-teal-950/95 backdrop-blur-md shadow-lg border-b border-teal-800/50">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/sanmiguel-logo.png') }}" alt="San Miguel Logo" class="h-9 w-9 object-contain">
                <img src="{{ asset('images/rhu-logo.png') }}" alt="RHU Logo" class="h-9 w-9 object-contain">
                <span class="font-bold text-lg tracking-wide hidden sm:block">RHU San Miguel</span>
            </div>

            <div class="hidden lg:flex items-center gap-6 font-medium text-sm">
                <a href="#" class="bg-white text-teal-800 px-4 py-2 rounded-full shadow-sm">Home</a>
                <a href="#" class="hover:text-teal-200 transition">About Us</a>
                <a href="#" class="hover:text-teal-200 transition">Services +</a>
                <a href="#" class="hover:text-teal-200 transition">Announcements</a>
                <a href="#" class="hover:text-teal-200 transition">Contact Us</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="/login" class="hidden md:inline-block bg-white text-teal-700 px-5 py-2 rounded-full font-bold text-sm shadow hover:bg-gray-100 transition">
                    Staff Login
                </a>
                
                <button class="lg:hidden text-white focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <div class="relative z-10 px-6 lg:px-12 pt-28 lg:pt-36 pb-12 flex flex-col h-full justify-center">
            
            <div class="max-w-3xl">
                <p class="text-green-400 font-bold tracking-widest text-xs mb-3 uppercase">
                    Municipal Health Office of San Miguel
                </p>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-8">
                    Accessible, FACILITY<br class="hidden md:block"> 
                    Healthcare For <br class="hidden md:block"> 
                    The Community 
                </h1>
                
                <div class="flex flex-col sm:flex-row items-center gap-4 lg:gap-8">
                    <a href="#" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-full flex items-center justify-center gap-2 transition shadow-lg text-sm md:text-base">
                        View Services &rarr;
                    </a>
                    
                    <div class="flex items-center gap-3 text-white w-full sm:w-auto">
                        <div class="bg-white/10 p-3 rounded-full border border-white/20 backdrop-blur-sm">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-300">Emergency Hotlines</p>
                            <p class="font-bold text-base md:text-lg tracking-wide">0995-1496988</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 lg:mt-16 max-w-sm w-full bg-white rounded-2xl p-6 shadow-2xl relative border-b-8 border-green-500">
                <div class="flex items-center gap-2 text-green-700 font-extrabold text-lg mb-4">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Clinic Hours
                </div>
                
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium text-sm">Monday - Friday</span>
                    <span class="text-green-600 font-bold text-sm">8:00am - 5:00pm</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-600 font-medium text-sm">Saturday - Sunday</span>
                    <span class="text-green-600 font-bold text-sm">Closed for Walk-ins</span>
                </div>
            </div>

        </div>
    </div>

</body>
</html>