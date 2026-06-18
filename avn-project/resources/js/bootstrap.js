import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

window.Echo.channel('telemetry')
    .listen('TelemetryReceived', (e) => {
        console.log('Telemetry received:', e.telemetry);
        // Logic to update UI, markers, or charts
    });

window.Echo.channel('alerts')
    .listen('AlertTriggered', (e) => {
        console.log('Alert triggered:', e.alert);
        alert('ALERT: ' + e.alert.message);
    });
