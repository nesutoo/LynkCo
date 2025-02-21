// Initialize Firebase (make sure this is after your firebase app initialization)
const db = firebase.firestore();
const presenceRef = db.collection('presence');
const userId = document.querySelector('footer').querySelector('.text-xs').textContent.replace('#', '');

class PresenceService {
    constructor() {
        this.setupPresence();
        this.listenToPresenceChanges();
    }

    setupPresence() {
        // Update user's status when online
        const userStatusRef = presenceRef.doc(userId);
        
        // Set initial online status
        this.setOnlineStatus();

        // Update status when tab visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                this.setOnlineStatus();
            } else {
                this.setOfflineStatus();
            }
        });

        // Update status when window closes/refreshes
        window.addEventListener('beforeunload', () => {
            this.setOfflineStatus();
        });
    }

    async setOnlineStatus() {
        try {
            await presenceRef.doc(userId).set({
                status: 'online',
                lastSeen: firebase.firestore.FieldValue.serverTimestamp(),
                name: document.querySelector('footer .text-sm').textContent.trim()
            }, { merge: true });
        } catch (error) {
            console.error('Error setting online status:', error);
        }
    }

    async setOfflineStatus() {
        try {
            await presenceRef.doc(userId).set({
                status: 'offline',
                lastSeen: firebase.firestore.FieldValue.serverTimestamp()
            }, { merge: true });
        } catch (error) {
            console.error('Error setting offline status:', error);
        }
    }

    listenToPresenceChanges() {
        // Listen for online users
        presenceRef.where('status', '==', 'online')
            .onSnapshot((snapshot) => {
                const onlineCount = snapshot.docs.length;
                // Update the online count in the UI
                const onlineButton = document.querySelector('[data-status="online"]');
                if (onlineButton) {
                    onlineButton.textContent = `Online - ${onlineCount}`;
                }

                // Update DM list with online status
                this.updateDMList(snapshot.docs);
            });
    }

    updateDMList(onlineUsers) {
        const dmList = document.getElementById('dmList');
        const onlineUserIds = onlineUsers.map(doc => doc.id);

        // Update status indicators for each DM in the list
        const dmItems = dmList.querySelectorAll('.dm-item');
        dmItems.forEach(item => {
            const userId = item.dataset.userId;
            const statusIndicator = item.querySelector('.status-indicator');
            
            if (statusIndicator) {
                statusIndicator.classList.toggle('bg-green-500', onlineUserIds.includes(userId));
                statusIndicator.classList.toggle('bg-gray-500', !onlineUserIds.includes(userId));
            }
        });
    }
}

// Initialize the presence service
const presenceService = new PresenceService();