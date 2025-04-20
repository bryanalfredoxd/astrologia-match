self.addEventListener('install', function(e) {
    console.log('[ServiceWorker] Install');
  });
  
  self.addEventListener('fetch', function(e) {
    // Se puede agregar lógica de caché aquí
  });
  