// firebase.js
import { initializeApp } from "firebase/app";
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword, signOut } from "firebase/auth";

const firebaseConfig = {
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
    return auth.onAuthStateChanged(callback);
};

