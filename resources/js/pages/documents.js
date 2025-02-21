// resources/js/pages/documents.js
import { firestoreService } from '../services/firestoreService';

document.addEventListener('DOMContentLoaded', async function() {
    // Contoh mengambil semua dokumen
    try {
        const documents = await firestoreService.getAllDocuments();
        console.log('All documents:', documents);
    } catch (error) {
        console.error('Failed to fetch documents:', error);
    }

    // Contoh menambah dokumen baru
    const addDocumentForm = document.getElementById('addDocumentForm');
    addDocumentForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const newDocument = {
                field1: document.getElementById('field1').value,
                field2: document.getElementById('field2').value
            };
            
            const result = await firestoreService.addDocument(newDocument);
            console.log('Document added:', result);
            
            // Reset form
            this.reset();
        } catch (error) {
            console.error('Failed to add document:', error);
        }
    });

    // Contoh update dokumen
    const updateDocumentForm = document.getElementById('updateDocumentForm');
    updateDocumentForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            const documentId = document.getElementById('documentId').value;
            const updatedData = {
                field1: document.getElementById('updateField1').value
            };
            
            const result = await firestoreService.updateDocument(documentId, updatedData);
            console.log('Document updated:', result);
        } catch (error) {
            console.error('Failed to update document:', error);
        }
    });
});