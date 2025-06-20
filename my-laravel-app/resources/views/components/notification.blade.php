<!-- Notification Container -->
<div id="notificationContainer"></div>

<!-- Notification Styles -->
<style>
#notificationContainer {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 10000;
    max-width: 400px;
}

.notification {
    background: #10b981;
    color: white;
    padding: 16px 20px;
    border-radius: 8px;
    border-left: 4px solid #059669;
    margin-bottom: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 12px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    line-height: 1.4;
    transform: translateX(100%);
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
}

.notification-success { background: #10b981; border-left-color: #059669; }
.notification-error { background: #ef4444; border-left-color: #dc2626; }
.notification-warning { background: #f59e0b; border-left-color: #d97706; }
.notification-info { background: #3b82f6; border-left-color: #2563eb; }

@media (max-width: 768px) {
    #notificationContainer {
        right: 10px;
        left: 10px;
        max-width: none;
    }
}
</style>

<!-- Notification JavaScript -->
<script>
function createNotificationContainer() {
    if (!document.getElementById('notificationContainer')) {
        const container = document.createElement('div');
        container.id = 'notificationContainer';
        document.body.appendChild(container);
    }
}

function showNotification(message, type = 'success', duration = 5000) {
    createNotificationContainer();

    const colors = {
        success: { bg: '#10b981', border: '#059669' },
        error: { bg: '#ef4444', border: '#dc2626' },
        warning: { bg: '#f59e0b', border: '#d97706' },
        info: { bg: '#3b82f6', border: '#2563eb' }
    };

    const icons = {
        success: '✓',
        error: '✕',
        warning: '⚠',
        info: 'ℹ'
    };

    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <span style="font-size: 16px; font-weight: bold;">${icons[type]}</span>
        <span style="flex: 1;">${message}</span>
        <span style="opacity: 0.7; font-size: 18px; padding-left: 8px;">×</span>
    `;

    notification.addEventListener('click', () => dismissNotification(notification));

    document.getElementById('notificationContainer').appendChild(notification);

    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    if (duration > 0) {
        setTimeout(() => dismissNotification(notification), duration);
    }
}

function dismissNotification(notification) {
    notification.style.transform = 'translateX(100%)';
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 300);
}

// Shorthand helpers
function showSuccessMessage(message) { showNotification(message, 'success'); }
function showErrorMessage(message) { showNotification(message, 'error'); }
function showWarningMessage(message) { showNotification(message, 'warning'); }
function showInfoMessage(message) { showNotification(message, 'info'); }

// Auto show from session (blade injects below)
</script>

<!-- Session Messages -->
@if(session('success'))
<script>document.addEventListener('DOMContentLoaded', () => showSuccessMessage("{{ session('success') }}"));</script>
@endif

@if(session('error'))
<script>document.addEventListener('DOMContentLoaded', () => showErrorMessage("{{ session('error') }}"));</script>
@endif

@if(session('warning'))
<script>document.addEventListener('DOMContentLoaded', () => showWarningMessage("{{ session('warning') }}"));</script>
@endif

@if(session('info'))
<script>document.addEventListener('DOMContentLoaded', () => showInfoMessage("{{ session('info') }}"));</script>
@endif
<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
</div>