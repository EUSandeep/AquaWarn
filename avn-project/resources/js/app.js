import './bootstrap';

window.addEventListener('DOMContentLoaded', () => {
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel('telemetry')
            .listen('TelemetryReceived', (e) => {
                console.log('Telemetry received:', e.telemetry);

                // Update stats if on dashboard
                const avgVal = document.querySelector('.stat-value:nth-child(3)');
                if (avgVal) {
                    // Simple mock update for demonstration
                    console.log('Updating dashboard stats...');
                }

                // Update chart if on node details page
                if (window.nodeChart && window.currentNodeId == e.telemetry.telemetry_node_id) {
                    console.log('Updating chart for node', e.telemetry.telemetry_node_id);
                    const chart = window.nodeChart;
                    chart.data.datasets[0].data.push(e.telemetry.water_level);
                    chart.data.labels.push(new Date(e.telemetry.recorded_at).toLocaleTimeString());
                    // Remove first if too many
                    if (chart.data.datasets[0].data.length > 30) {
                        chart.data.datasets[0].data.shift();
                        chart.data.labels.shift();
                    }
                    chart.update();
                }
            });

        window.Echo.channel('alerts')
            .listen('AlertTriggered', (e) => {
                console.log('Alert triggered:', e.alert);
                // Create a floating alert notification
                const notification = document.createElement('div');
                notification.style.position = 'fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.padding = '1rem 2rem';
                notification.style.background = e.alert.severity === 'critical' ? '#ef4444' : '#f59e0b';
                notification.style.color = 'white';
                notification.style.borderRadius = '8px';
                notification.style.boxShadow = '0 4px 12px rgba(0,0,0,0.5)';
                notification.style.zIndex = '9999';
                notification.innerHTML = `<strong>ALERT:</strong> ${e.alert.message}`;
                document.body.appendChild(notification);

                setTimeout(() => notification.remove(), 10000);
            });
    }
});
