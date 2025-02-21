// resources/js/services/firestoreService.js

class FirestoreService {
    constructor() {
        this.baseUrl = '/api/firestore';
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    }

    async getAllDocuments() {
        try {
            const response = await fetch(this.baseUrl);
            if (!response.ok) throw new Error('Failed to fetch documents');
            return await response.json();
        } catch (error) {
            console.error('Error fetching documents:', error);
            throw error;
        }
    }

    async addDocument(data) {
        try {
            const response = await fetch(this.baseUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) throw new Error('Failed to add document');
            return await response.json();
        } catch (error) {
            console.error('Error adding document:', error);
            throw error;
        }
    }

    async updateDocument(documentId, data) {
        try {
            const response = await fetch(`${this.baseUrl}/${documentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify(data)
            });
            if (!response.ok) throw new Error('Failed to update document');
            return await response.json();
        } catch (error) {
            console.error('Error updating document:', error);
            throw error;
        }
    }

    async deleteDocument(documentId) {
        try {
            const response = await fetch(`${this.baseUrl}/${documentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken
                }
            });
            if (!response.ok) throw new Error('Failed to delete document');
            return await response.json();
        } catch (error) {
            console.error('Error deleting document:', error);
            throw error;
        }
    }
}

export const firestoreService = new FirestoreService();