<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - LynkCo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/js/firebase.js', 'resources/js/logout.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-blue-600 text-white shadow-md">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold">LynkCo</h1>
                    <nav class="hidden md:flex space-x-4">
                        <a href="#" class="hover:text-blue-200 transition">Home</a>
                        <a href="#" class="hover:text-blue-200 transition">Projects</a>
                        <a href="#" class="hover:text-blue-200 transition">Reports</a>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="hidden md:inline">Welcome, {{ Auth::user()->name }}</span>
                    <form id="logoutForm" class="inline">
                        <button 
                            type="submit" 
                            class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                            id="logoutButton"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="flex-1 flex">
            <!-- Sidebar -->
            <aside class="w-64 bg-white shadow-md hidden md:block">
                <nav class="p-4 space-y-2">
                    <div class="mb-4">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="block px-4 py-2 rounded-md hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition">
                        Dashboard
                    </a>
                    <a href="#" class="block px-4 py-2 rounded-md hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition">
                        Projects
                    </a>
                    <a href="#" class="block px-4 py-2 rounded-md hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition">
                        Tasks
                    </a>
                    <a href="#" class="block px-4 py-2 rounded-md hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition">
                        Reports
                    </a>
                    <a href="#" class="block px-4 py-2 rounded-md hover:bg-blue-50 text-gray-700 hover:text-blue-600 transition">
                        Settings
                    </a>
                </nav>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 p-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Dashboard Overview</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Total Projects</h3>
                            <p class="text-3xl font-bold text-blue-600">12</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Active Tasks</h3>
                            <p class="text-3xl font-bold text-green-600">24</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Team Members</h3>
                            <p class="text-3xl font-bold text-purple-600">8</p>
                        </div>
                    </div>
                    <!-- Add more dashboard content here -->
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white shadow-md mt-auto">
            <div class="container mx-auto px-4 py-3 text-center text-gray-600">
                <p>&copy; 2024 LynkCo. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-4 rounded-lg">
            <p class="text-gray-700">Logging out...</p>
        </div>
    </div>
</body>
</html>