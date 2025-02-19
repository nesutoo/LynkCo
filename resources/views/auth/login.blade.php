<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - LynkCo</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/js/firebase.js', 'resources/js/login.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .relative {
            position: relative;

        }
        #togglePassword {
            background: none;
            border: none;
            cursor: pointer;
            color: white;
        }

        .icon{
            position: relative;
            top: 14px;
            width: 25px
        }
    </style>

</head>
<body style="background-image: linear-gradient(to right, #0f0b87,rgb(214, 221, 255)">
    <main>
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="flex flex-col md:flex-row gap-5 justify-center items-center bg-white p-8 md:p-10 rounded-lg shadow-lg w-full max-w-4xl" style="background-color: #242b4a">
                <div class="w-full md:w-1/2 flex items-center justify-center">
                    <div class="heading text-center">
                        <img src="https://via.placeholder.com/150" alt="LynkCo Logo" class="mb-4 rounded-lg mx-auto">
                        <h2 class="text-2xl font-bold text-white" >Welcome to LynkCo!</h2>
                        <p class="">Please login to access your account.</p>
                    </div>
                </div>

                <div class="heading2 w-full md:w-1/2">
                    <h1 class="text-2xl font-bold mb-6">Login</h1>
                    <form id="loginForm" class="space-y-4">
                        <div>
                            <label for="email" class="block font-medium mb-1">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                required 
                                class="w-full px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Enter your email"
                                style="background-color: #374066"
                            >
                            <span id="emailError" class="text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="relative">
                            <label for="password" class="block font-medium mb-1">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Enter your password"
                                style="background-color: #374066"
                            >
                            <button 
                                type="button" 
                                id="togglePassword" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3"
                                onclick="togglePasswordVisibility()"
                            >
                                <svg 
                                    id="eyeIcon" 
                                    xmlns="http://www.w3.org/2000/svg" 
                                    class="icon h-5 w-5 text-white" 
                                    fill="none" 
                                    viewBox="0 0 24 24" 
                                    stroke="currentColor"
                                >
                                    <path 
                                        id="eyePath" 
                                        stroke-linecap="round" 
                                        stroke-linejoin="round" 
                                        stroke-width="2" 
                                        d="M12 3c-6.627 0-12 6-12 9s5.373 9 12 9 12-6 12-9-5.373-9-12-9zm0 14c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" 
                                    />
                                </svg>
                            </button>
                            <span id="passwordError" class="text-red-500 text-sm hidden"></span>
                        </div>
                        
                        <button
                            type="submit" 
                            class="w-full text-white font-bold py-3 px-4 rounded-md hover:bg-blue-600 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                            id="loginButton"
                            style="background-color:#455080;"    
                        >
                            Login
                        </button>

                        <div id="errorMessage" class="text-red-500 text-center hidden"></div>
                    </form>
                    
                    <p class="mt-6 text-center text-white">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600 font-medium">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');
    
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            eyeIcon.setAttribute('d', isPassword 
                ? 'M12 12c3.313 0 6 2.686 6 6s-2.687 6-6 6-6-2.686-6-6 2.687-6 6-6z' 
                : 'M3 12c0 0 9 9 18 0 0 0-9-9-18 0z');
        }
    </script>
</body>
</html>