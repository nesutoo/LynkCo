// login.js
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
            if (element) {
                element.textContent = '';
                element.classList.add('hidden');
            }
        });
    }

    function setLoading(isLoading) {
        if (loginButton) {
            loginButton.disabled = isLoading;
            loginButton.textContent = isLoading ? 'Logging in...' : 'Login';
            loginButton.classList.toggle('opacity-75', isLoading);
        }
    }

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    loginForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        hideErrors();

        const email = document.getElementById('email')?.value.trim();
        const password = document.getElementById('password')?.value;

        if (!email) {
            showError('Email is required', emailError);
            return;
        }

        if (!validateEmail(email)) {
            showError('Please enter a valid email address', emailError);
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
            const idToken = await userCredential.user.getIdToken();
            
            // Laravel Authentication
            const response = await fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Authorization': `Bearer ${idToken}`
                },
                body: JSON.stringify({ email, password })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Login failed');
            }

            window.location.href = data.redirect || '/dashboard';

        } catch (error) {
            console.error('Login error:', error);
            showError(error.message || 'Invalid email or password. Please try again.');
        } finally {
            setLoading(false);
        }
    });
});