<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script type="module" src="{{ mix('js/app.js') }}"></script>
</head>
<body>
    <main>
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="flex flex-col md:flex-row gap-5 justify-center items-center bg-white p-8 md:p-10 rounded shadow-md w-full max-w-4xl">
                <div class="w-full md:w-1/2 flex items-center justify-center">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/150" alt="Information Image" class="mb-4 rounded-lg mx-auto">
                        <h2 class="text-xl font-bold">Welcome Back!</h2>
                        <p class="text-gray-600">Please Login to access your account.</p>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <h1 class="text-2xl font-bold mb-6">Login</h1>
                    <form id="loginForm" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50" value="{{ old('email') }}">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded hover:bg-blue-600">Login</button>
                    </form>
                    <p class="mt-4 text-sm text-center">Don't have an account? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register here</a>.</p>
                </div>
            </div>
        </div>
    </main>

    {{-- <script type="module">
        import { signIn } from './firebase.js'; // Adjust the path if necessary

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            signIn(email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    console.log('User  logged in:', user);
                    // Optionally redirect or show a success message
                })
                .catch((error) => {
                    console.error('Error logging in:', error);
                });
        });
    </script> --}}
</body>
</html>