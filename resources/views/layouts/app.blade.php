<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'News Portal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">
                        <a href="{{ route('home') }}">News Portal</a>
                    </h1>
                </div>
                
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                    @foreach(\App\Models\Category::where('show_on_menu', true)->orderBy('sort_order')->get() as $category)
                        <a href="{{ route('category', $category->slug) }}" class="text-gray-700 hover:text-blue-600">{{ $category->name }}</a>
                    @endforeach
                </nav>

                <div class="flex items-center space-x-4">
                    <form action="{{ route('search') }}" method="GET" class="flex">
                        <input type="text" name="q" placeholder="Search..." class="px-3 py-1 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-r-md hover:bg-blue-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} News Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>