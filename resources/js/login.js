import { signIn } from './firebase.js';

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');
    const errorMessage = document.getElementById('errorMessage');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    function showError(message, element = errorMessage) {
        element.textContent = message;
        element.classList.remove('hidden');
    }

    function hideErrors() {
        [errorMessage, emailError, passwordError].forEach(element => {
            element.textContent = '';
            element.classList.add('hidden');
        });
    }

    function setLoading(isLoading) {
        loginButton.disabled = isLoading;
        loginButton.textContent = isLoading ? 'Logging in...' : 'Login';
        loginButton.classList.toggle('opacity-75', isLoading);
    }

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        hideErrors();

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        if (!email) {
            showError('Email is required', emailError);
            return;
        }

        if (!password) {
            showError('Password is required', passwordError);
            return;
        }

        setLoading(true);

        try {
            // Firebase Authentication
            const userCredential = await signIn(email, password);
            
            // Laravel Authentication
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Login failed');
            }

            // Redirect to dashboard
            window.location.href = data.redirect || '/dashboard';

        } catch (error) {
            console.error('Login error:', error);
            showError(error.message || 'An error occurred during login. Please try again.');
        } finally {
            setLoading(false);
        }
<<<<<<< HEAD
        
=======
>>>>>>> 2dc4f10692dc9f5a4c1e8989a73ddaa2c58c2a16
    });
});