import { initializeApp } from "firebase/app";
import { getAuth, createUserWithEmailAndPassword } from "firebase/auth";

const firebaseConfig = {
    apiKey: "AIzaSyCIpr524siBF_b0jIRXO6oUAe02iKZrzkA",
    authDomain: "lynkco-id.firebaseapp.com",
    projectId: "lynkco-id",
    storageBucket: "lynkco-id.appspot.com",
    messagingSenderId: "704246471313",
    appId: "1:704246471313:web:5d6045603d9e8cee917d30"
};

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

export const signUp = (email, password) => {
    return createUserWithEmailAndPassword(auth, email, password);
};