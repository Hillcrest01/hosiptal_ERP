import './bootstrap';
import 'bootstrap';
import 'admin-lte';

document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const closeButton = alert.querySelector('.close');
            if (closeButton) {
                closeButton.click();
            }
        }, 5000);
    });
});

console.log('Hospital ERP ready');