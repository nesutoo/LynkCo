<!-- register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - LynkCo</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/js/firebase.js', 'resources/js/register.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body style="background-image: linear-gradient(to right, #000931,rgb(214, 221, 255)">
    <main>
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="flex flex-col md:flex-row gap-5 justify-center items-center bg-white p-8 md:p-10 rounded-lg shadow-lg w-full max-w-4xl" style="background-color: #242b4a">
                <div class="w-full md:w-1/2 flex items-center justify-center">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/150" alt="LynkCo Logo" class="mb-4 rounded-lg mx-auto shadow-md">
                        <h2 class="text-2xl font-bold text-white">Welcome to LynkCo!</h2>
                        <p class="text-gray-400 mt-2">Create your account to get started.</p>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <h1 class="text-2xl font-bold mb-6 text-white">Create Account</h1>
                    <form id="registerForm" class="space-y-4">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-white font-medium mb-1">Full Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Enter your full name"
                                minlength="2"
                                maxlength="50"
                                style="background-color: #374066"
                            >
                            <span id="nameError" class="text-red-500 text-sm mt-1 hidden"></span>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-white font-medium mb-1">Email Address</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Enter your email"
                                style="background-color: #374066"
                            >
                            <span id="emailError" class="text-red-500 text-sm mt-1 hidden"></span>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-white font-medium mb-1">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Create a password"
                                minlength="8"
                                style="background-color: #374066"
                            >
                            <span id="passwordError" class="text-red-500 text-sm mt-1 hidden"></span>
                            <p class="text-gray-400 text-sm mt-1">Password must be at least 8 characters</p>
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label for="password_confirmation" class="block text-white font-medium mb-1">Confirm Password</label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Confirm your password"
                                minlength="8"
                                style="background-color: #374066"
                            >
                            <span id="confirmPasswordError" class="text-red-500 text-sm mt-1 hidden"></span>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full bg-blue-500 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                            id="registerButton"
                            style="background-color:#455080"
                        >
                            Create Account
                        </button>

                        <!-- General Error Message -->
                        <div id="errorMessage" class="text-red-500 text-center hidden"></div>
                    </form>
                    
                    <p class="mt-6 text-center text-white">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-medium">
                            Login here
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded-lg shadow-xl">
                <p class="text-gray-700">Creating your account...</p>
            </div>
        </div>
    </main>
</body>
</html>