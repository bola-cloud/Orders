importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyAleINt2_2hmE7Byk3KCQD_MnUAkGY3_Y4",
    authDomain: "food-app-acee4.firebaseapp.com",
    projectId: "food-app-acee4",
    storageBucket: "food-app-acee4.firebasestorage.app",
    messagingSenderId: "993977824897",
    appId: "1:993977824897:web:73a4058635be2046127f80",
    measurementId: ""
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    return self.registration.showNotification(payload.data.title, {
        body: payload.data.body ? payload.data.body : '',
        icon: payload.data.icon ? payload.data.icon : ''
    });
});