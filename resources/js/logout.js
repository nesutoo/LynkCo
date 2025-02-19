import { logout } from './firebase.js';

document.addEventListener('DOMContentLoaded', function() {
    const logoutForm = document.getElementById('logoutForm');
    const logoutButton = document.getElementById('logoutButton');
    const loadingOverlay = document.getElementById('loadingOverlay');

    function showLoading() {
        loadingOverlay.classList.remove('hidden');
        logoutButton.disabled = true;
        logoutButton.textContent = 'Logging out...';
    }

    function hideLoading() {
        loadingOverlay.classList.add('hidden');
        logoutButton.disabled = false;
        logoutButton.textContent = 'Logout';
    }

    async function handleLogout(e) {
        e.preventDefault();
        showLoading();

        try {
            // Firebase logout
            await logout();

            // Laravel logout
            const response = await fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error('Failed to logout from server');
            }

            // Successful logout
            window.location.href = '/login';
        } catch (error) {
            console.error('Logout error:', error);
            hideLoading();
            alert('Failed to logout. Please try again.');
        }
    }

    logoutForm.addEventListener('submit', handleLogout);

    // Handle beforeunload to prevent accidental navigation during logout
    window.addEventListener('beforeunload', (e) => {
        if (logoutButton.disabled) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
});