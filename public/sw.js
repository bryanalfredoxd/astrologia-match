const CACHE_NAME = 'astromatch-v3';
const ASSETS_TO_CACHE = [
  '/',
  '/manifest.json',
  '/css/app.css',
  '/js/app.js',
  '/images/fondo1.webp',
  '/images/fondo1-mobile.webp',
  '/images/logo.webp',
  '/images/splash/icon-192x192.webp',
  '/images/splash/icon-512x512.webp'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(ASSETS_TO_CACHE))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') return;
  
  event.respondWith(
    caches.match(event.request)
      .then(cached => {
        const fetchPromise = fetch(event.request)
          .then(response => {
            // Cachear nuevas respuestas
            const responseClone = response.clone();
            caches.open(CACHE_NAME)
              .then(cache => cache.put(event.request, responseClone));
            return response;
          });
        return cached || fetchPromise;
      })
  );
});