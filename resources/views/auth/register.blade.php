<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <main>
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="flex flex-col md:flex-row gap-5 justify-center items-center bg-white p-8 md:p-10 rounded shadow-md w-full max-w-4xl">
                <div class="w-full md:w-1/2 flex items-center justify-center">
                    <div class="text-center">
                        <img src="https://via.placeholder.com/150" alt="Information Image" class="mb-4 rounded-lg mx-auto">
                        <h2 class="text-xl font-bold">Welcome to LynkCo!</h2>
                        <p class="text-gray-600">Please Register to access your account.</p>
                    </div>
                </div>

                <div class="w-full md:w-1/2">
                    <h1 class="text-2xl font-bold mb-6">Register</h1>
                    <form id="registerForm">
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Name</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" name="email" id="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700">Password</label>
                            <input type="password" name="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                        </div>

                        <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded hover:bg-blue-600">Register</button>
                    </form>
                    <p class="mt-4 text-center">Already have an account? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login here</a>.</p>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ mix('js/app.js') }}"></script>
    <script type="module">
        import { signUp } from './firebase.js';

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            // Validate password match
            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return;
            }

            // Register user with Firebase
            signUp(email, password)
                .then((userCredential) => {
                    const user = userCredential.user;
                    console.log('User registered:', user);
                    alert('Registration successful!');
                    // Redirect to dashboard or login page
                    window.location.href = '/dashboard'; // Update this URL as needed
                })
                .catch((error) => {
                    console.error('Error registering:', error);
                    alert(`Registration failed: ${error.message}`);
                });
        });
    </script>
</body>
</html>