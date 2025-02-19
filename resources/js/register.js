import { signUp } from './firebase.js';

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
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

            // Send user data to Laravel backend
            fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: confirmPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                alert('Registration successful!');
                window.location.href = '/dashboard'; // Redirect to dashboard
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Registration failed. Please try again.');
            });
        })
        .catch((error) => {
            console.error('Error registering:', error);
            alert(`Registration failed: ${error.message}`);
        });
});