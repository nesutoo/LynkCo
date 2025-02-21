// resources/js/dashboard.js
import { presenceService } from './services/presenceService';

document.addEventListener('DOMContentLoaded', function() {
    const onlineCountButton = document.querySelector('[data-status="online"]');
    const dmList = document.getElementById('dmList');

    // Update online users count and list
    presenceService.listenToOnlineUsers((onlineUsers) => {
        // Update online count
        if (onlineCountButton) {
            onlineCountButton.textContent = `Online - ${onlineUsers.length}`;
        }

        // Update DM list
        if (dmList) {
            dmList.innerHTML = onlineUsers.map(user => `
                <div class="flex items-center gap-3 p-2 rounded cursor-pointer hover:bg-zinc-700 transition-colors">
                    <div class="relative">
                        <div class="w-8 h-8 rounded-full bg-zinc-700 flex items-center justify-center">
                            <i class="ti ti-user text-sm"></i>
                        </div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-zinc-800"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-zinc-300 truncate">${user.email}</div>
                        <div class="text-xs text-zinc-400">Online</div>
                    </div>
                </div>
            `).join('');
        }

        // Update main content if no online users
        const mainContent = document.getElementById('mainContent');
        if (mainContent && onlineUsers.length === 0) {
            mainContent.innerHTML = `
                <div class="flex flex-col gap-6 items-center">
                    <img 
                        src="/api/placeholder/400/200" 
                        alt="Wumpus character illustration showing no friends are currently online" 
                        class="rounded-lg"
                        width="400"
                        height="200"
                    />
                    <p class="text-zinc-400 text-lg">No one's around to play with Wumpus.</p>
                </div>
            `;
        }
    });
});

// Add this to your dashboard.js or create a new status.js file
class UserStatusManager {
    constructor() {
        this.db = firebase.firestore();
        this.statusRef = this.db.collection('status');
        this.currentUserId = document.querySelector('meta[name="user-id"]').content;
    }

    initialize() {
        // Listen for status changes
        this.statusRef.onSnapshot(snapshot => {
            snapshot.docChanges().forEach(change => {
                const userId = change.doc.id;
                const status = change.doc.data().state;
                this.updateUserStatusUI(userId, status);
            });
        });

        // Set initial status for current user
        this.setUserStatus('online');

        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            const status = document.hidden ? 'away' : 'online';
            this.setUserStatus(status);
        });

        // Handle before unload
        window.addEventListener('beforeunload', () => {
            this.setUserStatus('offline');
        });
    }

    updateUserStatusUI(userId, status) {
        const userElements = document.querySelectorAll(`[data-user-id="${userId}"] .status-dot`);
        userElements.forEach(dot => {
            // Remove all status classes
            dot.classList.remove('online', 'offline', 'away');
            // Add current status class
            dot.classList.add(status);
            // Add animation for status change
            dot.classList.add('animate');
            setTimeout(() => dot.classList.remove('animate'), 2000);
        });
    }

    async setUserStatus(status) {
        try {
            await this.statusRef.doc(this.currentUserId).set({
                state: status,
                lastUpdated: firebase.firestore.FieldValue.serverTimestamp()
            });
        } catch (error) {
            console.error('Error updating status:', error);
        }
    }
}

// Initialize status manager
document.addEventListener('DOMContentLoaded', () => {
    const statusManager = new UserStatusManager();
    statusManager.initialize();
});