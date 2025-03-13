<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <h3 class="text-xl font-bold">IOT Dashboard</h3>
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <span class="mr-4 text-gray-700">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        &nbsp;&nbsp;&nbsp;<button type="submit" class="text-red-500 hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 mr-4">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
