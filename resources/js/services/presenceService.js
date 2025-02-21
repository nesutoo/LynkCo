// resources/js/services/presenceService.js
import { getDatabase, ref, onDisconnect, set, onValue } from 'firebase/database';
import { onAuthStateChanged } from 'firebase/auth';
import { auth } from '../firebase';

class PresenceService {
    constructor() {
        this.database = getDatabase();
        this.setupPresence();
    }

    setupPresence() {
        onAuthStateChanged(auth, (user) => {
            if (user) {
                // Create references
                const userStatusRef = ref(this.database, `/status/${user.uid}`);
                const userStatusDatabaseRef = ref(this.database, '.info/connected');

                onValue(userStatusDatabaseRef, (snapshot) => {
                    if (snapshot.val() === false) {
                        return;
                    }

                    onDisconnect(userStatusRef)
                        .set({
                            status: 'offline',
                            last_seen: new Date().toISOString(),
                            email: user.email
                        })
                        .then(() => {
                            set(userStatusRef, {
                                status: 'online',
                                last_seen: new Date().toISOString(),
                                email: user.email
                            });
                        });
                });

                // Handle window visibility change
                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'visible') {
                        set(userStatusRef, {
                            status: 'online',
                            last_seen: new Date().toISOString(),
                            email: user.email
                        });
                    } else {
                        set(userStatusRef, {
                            status: 'away',
                            last_seen: new Date().toISOString(),
                            email: user.email
                        });
                    }
                });
            }
        });
    }

    listenToOnlineUsers(callback) {
        const statusRef = ref(this.database, '/status');
        onValue(statusRef, (snapshot) => {
            const statuses = snapshot.val();
            const onlineUsers = [];
            
            for (let uid in statuses) {
                if (statuses[uid].status === 'online') {
                    onlineUsers.push({
                        uid,
                        email: statuses[uid].email,
                        last_seen: statuses[uid].last_seen
                    });
                }
            }
            
            callback(onlineUsers);
        });
    }
}

export const presenceService = new PresenceService();