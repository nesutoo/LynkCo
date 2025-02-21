// register.js
import { signUp } from './firebase.js';

document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const registerButton = document.getElementById('registerButton');

    function setLoading(isLoading) {
        if (registerButton) {
            registerButton.disabled = isLoading;
            registerButton.textContent = isLoading ? 'Registering...' : 'Register';
            registerButton.classList.toggle('opacity-75', isLoading);
        }
    }

    function validatePassword(password) {
        return password.length >= 8;
    }

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    registerForm?.addEventListener('submit', async function(e) {
        e.preventDefault();

        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        const name = nameInput?.value.trim();
        const email = emailInput?.value.trim();
        const password = passwordInput?.value;
        const confirmPassword = confirmPasswordInput?.value;

        // Validate inputs
        if (!name) {
            alert('Name is required.');
            return;
        }

        if (!email || !validateEmail(email)) {
            alert('Please enter a valid email address.');
            return;
        }

        if (!validatePassword(password)) {
            alert('Password must be at least 8 characters long.');
            return;
        }

        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return;
        }

        setLoading(true);

        try {
            // Register user with Firebase
            const userCredential = await signUp(email, password);
            const idToken = await userCredential.user.getIdToken();

            // Send user data to Laravel backend
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                    'Authorization': `Bearer ${idToken}`
                },
                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation: confirmPassword
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Registration failed');
            }

            alert('Registration successful!');
            window.location.href = '/dashboard';
        } catch (error) {
            console.error('Registration error:', error);
            alert(error.message || 'Registration failed. Please try again.');
        } finally {
            setLoading(false);
        }
    });
});