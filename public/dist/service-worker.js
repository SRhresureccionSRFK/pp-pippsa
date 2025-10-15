/* global self caches fetch */

const CACHE_NAME = 'lochusa-shell-v1'
const DATA_CACHE = 'lochusa-data-v1'
const APP_SHELL = [
	'/',
	'/index.html',
	'/favicon.ico',
	'/manifest.json',
	'/icons/icon-192.png',
	'/icons/icon-512.png',
	'/js/chunk-vendors.js', // ajusta si tu build produce nombres diferentes
	'/js/app.js',
	'/css/app.css'
]

// Install: cache app shell
self.addEventListener('install', (event) => {
	self.skipWaiting()
	event.waitUntil(
		caches.open(CACHE_NAME).then((cache) => cache.addAll(APP_SHELL))
	)
})

// Activate: cleanup old caches
self.addEventListener('activate', (event) => {
	event.waitUntil(
		caches.keys().then((keys) => Promise.all(
			keys.map((key) => {
				if (key !== CACHE_NAME && key !== DATA_CACHE) return caches.delete(key)
			})
		)).then(() => self.clients.claim())
	)
})

// Fetch: assets -> cache-first, API -> network-first with cache fallback
self.addEventListener('fetch', (event) => {
	const { request } = event
	const url = new URL(request.url)

	// sólo manejar origen propio
	if (url.origin === self.location.origin) {
		// API calls (ej: /guardar-tareas, /api/...) -> network first
		if (request.method === 'POST' || url.pathname.startsWith('/api') || url.pathname.includes('/guardar')) {
			event.respondWith(
				fetch(request)
					.then((res) => {
						// opcional: cache response clone
						const resClone = res.clone()
						caches.open(DATA_CACHE).then((cache) => cache.put(request, resClone))
						return res
					})
					.catch(() => caches.match(request).then((r) => r || new Response(JSON.stringify({ error: 'offline' }), { status: 503, headers: { 'Content-Type': 'application/json' } })))
			)
			return
		}

		// assets -> cache-first
		event.respondWith(
			caches.match(request).then((cached) => cached || fetch(request).then((res) => {
				// cache assets on the fly
				if (request.method === 'GET') {
					const resClone = res.clone()
					caches.open(CACHE_NAME).then((cache) => cache.put(request, resClone))
				}
				return res
			})).catch(() => {
				// fallback: you can return an offline page for navigation requests
				if (request.mode === 'navigate') {
					return caches.match('/index.html')
				}
			})
		)
	}
})
