/* ASMI Shop — admin live-chat web push service worker.
 * Served at site root (scope "/") so it covers /admin/live-chat.
 * Receives DATA-only FCM messages and renders one notification; clicking it
 * focuses an existing admin chat tab or opens one. Config below is the
 * client-public Firebase web config (safe to ship). */
importScripts('https://www.gstatic.com/firebasejs/10.12.2/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.12.2/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: 'AIzaSyBGUw7ijdogjwlBpCgnJSVE2_hcmmalSX4',
  authDomain: 'asmi-shop.firebaseapp.com',
  projectId: 'asmi-shop',
  storageBucket: 'asmi-shop.firebasestorage.app',
  messagingSenderId: '401152501376',
  appId: '1:401152501376:web:146de2d90b8d1286eaa865',
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function (payload) {
  var d = payload.data || {};
  self.registration.showNotification(d.title || 'New message', {
    body: d.body || '',
    tag: 'asmi-chat',
    data: { url: d.url || '/admin/live-chat' },
  });
});

self.addEventListener('notificationclick', function (event) {
  event.notification.close();
  var url = (event.notification.data && event.notification.data.url) || '/admin/live-chat';
  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (list) {
      for (var i = 0; i < list.length; i++) {
        if (list[i].url.indexOf('/admin/live-chat') > -1 && 'focus' in list[i]) return list[i].focus();
      }
      if (clients.openWindow) return clients.openWindow(url);
    })
  );
});
