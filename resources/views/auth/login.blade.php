<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - LynkCo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/js/firebase.js', 'resources/js/login.js'])
</head>
<body class="bg-gray-100">
    <main>
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="flex flex-col md:flex-row gap-5 justify-center items-center bg-white p-8 md:p-10 rounded-lg shadow-lg w-full max-w-4xl">
                <div class="w-full md:w-1/2 flex items-center justify-center">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/150" alt="LynkCo Logo" class="mb-4 rounded-lg mx-auto">
                        <h2 class="text-2xl font-bold text-gray-800">Welcome to LynkCo!</h2>
                        <p class="text-gray-600 mt-2">Please login to access your account.</p>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <h1 class="text-2xl font-bold mb-6 text-gray-800">Login</h1>
                    <form id="loginForm" class="space-y-4">
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Enter your email"
                            >
                            <span id="emailError" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <div>
                            <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Enter your password"
                            >
                            <span id="passwordError" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-blue-500 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                            id="loginButton"
                        >
                            Login
                        </button>

                        <div id="errorMessage" class="text-red-500 text-center hidden"></div>
                    </form>
                    
                    <p class="mt-6 text-center text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600 font-medium">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>