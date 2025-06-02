const CACHE_NAME = 'astromatch-v4';
const OFFLINE_PAGE = '/offline.html';
const ASSETS_TO_CACHE = [
  '/',
  '/index.html',
  '/manifest.json',
  '/css/app.css',
  '/js/app.js',
  '/images/fondo1.webp',
  '/images/fondo1-mobile.webp',
  '/images/logo.webp',
  '/images/splash/icon-192x192.webp',
  '/images/splash/icon-256x256.webp',
  '/images/splash/icon-384x384.webp',
  '/images/splash/icon-512x512.webp',
  '/fonts/fa-solid-900.woff2',
  '/fonts/fa-brands-400.woff2',
  OFFLINE_PAGE
];

// Instalación del Service Worker
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('[Service Worker] Cacheando recursos esenciales');
        return cache.addAll(ASSETS_TO_CACHE);
      })
      .then(() => {
        console.log('[Service Worker] Instalación completada');
        return self.skipWaiting();
      })
      .catch((err) => {
        console.error('[Service Worker] Error durante la instalación:', err);
      })
  );
});

// Activación y limpieza de caches antiguos
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            console.log('[Service Worker] Eliminando cache antiguo:', cache);
            return caches.delete(cache);
          }
        })
      );
    })
    .then(() => {
      console.log('[Service Worker] Activación completada');
      return self.clients.claim();
    })
  );
});

// Estrategia de Cache con Network Fallback + Actualización en Segundo Plano
self.addEventListener('fetch', (event) => {
  // Ignorar solicitudes que no sean GET o de otro origen
  if (event.request.method !== 'GET' || 
      !event.request.url.startsWith(self.location.origin)) {
    return;
  }

  // Para solicitudes de la API, usa Network First
  if (event.request.url.includes('/api/')) {
    event.respondWith(
      fetch(event.request)
        .then((response) => {
          // Cachear respuestas de la API si es exitosa
          const responseClone = response.clone();
          caches.open(CACHE_NAME)
            .then((cache) => cache.put(event.request, responseClone));
          return response;
        })
        .catch(() => {
          // Fallback a caché si la red falla
          return caches.match(event.request);
        })
    );
    return;
  }

  // Para recursos estáticos, usa Cache First con actualización en segundo plano
  event.respondWith(
    caches.match(event.request)
      .then((cachedResponse) => {
        // Siempre hacer fetch para actualizar la caché
        const fetchPromise = fetch(event.request)
          .then((networkResponse) => {
            // Solo cachear respuestas válidas
            if (!networkResponse || networkResponse.status !== 200 || 
                networkResponse.type === 'opaque') {
              return networkResponse;
            }

            // Actualizar caché en segundo plano
            const responseClone = networkResponse.clone();
            caches.open(CACHE_NAME)
              .then((cache) => cache.put(event.request, responseClone));
            
            return networkResponse;
          })
          .catch(() => {
            // Si falla la red y no hay respuesta en caché, mostrar página offline
            if (event.request.mode === 'navigate') {
              return caches.match(OFFLINE_PAGE);
            }
          });

        // Devolver caché si existe, sino hacer fetch
        return cachedResponse || fetchPromise;
      })
  );
});

// Manejo de mensajes para actualizaciones
self.addEventListener('message', (event) => {
  if (event.data.action === 'skipWaiting') {
    self.skipWaiting();
  }
});