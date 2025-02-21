// firebase.js
import { initializeApp } from "firebase/app";
import { getFirestore } from 'firebase/firestore';
import { collection, getDocs } from 'firebase/firestore';
import { getDatabase } from 'firebase/database';
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword, signOut, onAuthStateChanged as onAuthStateChangedFirebase } from "firebase/auth";

const firebaseConfig = {
    databaseURL: "http://lynkco-id.firebaseapp.com/",
    apiKey: "AIzaSyCIpr524siBF_b0jIRXO6oUAe02iKZrzkA",
    authDomain: "lynkco-id.firebaseapp.com",
    projectId: "lynkco-id",
    storageBucket: "lynkco-id.firebasestorage.app",
    messagingSenderId: "704246471313",
    appId: "1:704246471313:web:5d6045603d9e8cee917d30"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);

export const database = getDatabase(app);

// Sign Up function
export const signUp = (email, password) => {
    return createUserWithEmailAndPassword(auth, email, password);
};

// Sign In function
export const signIn = (email, password) => {
    return signInWithEmailAndPassword(auth, email, password);
};

// Logout function
export const logout = async () => {
    try {
        await signOut(auth);
        return true;
    } catch (error) {
        console.error("Logout error:", error);
        throw error;
    }
};

// Get current user
export const getCurrentUser = () => {
    return auth.currentUser;
};

// Auth state observer
export const onAuthStateChanged = (callback) => {
    return onAuthStateChangedFirebase(auth, callback);
};

// Example of Firestore data fetch
export const getData = async (collectionName) => {
    try {
        const querySnapshot = await getDocs(collection(db, collectionName));
        const data = [];
        querySnapshot.forEach((doc) => {
            data.push({ id: doc.id, ...doc.data() });
        });
        return data;
    } catch (error) {
        console.error("Error fetching data:", error);
        throw error;
    }
};

export { db, auth };