// Real-time Notifications System
(function() {
    'use strict';

    let pusher = null;
    let notificationChannel = null;
    let unreadCount = 0;

    // Initialize Pusher
    function initPusher() {
        fetch('/admin/api/notification-settings/config')
            .then(response => response.json())
            .then(config => {
                if (config.enabled && config.key) {
                    pusher = new Pusher(config.key, {
                        cluster: config.cluster || 'ap2',
                        encrypted: true
                    });

                    notificationChannel = pusher.subscribe('admin-notifications');
                    
                    notificationChannel.bind('OrderNotificationCreated', function(data) {
                        addNotificationToDropdown(data);
                        updateUnreadCount(unreadCount + 1);
                        showBrowserNotification(data);
                    });

                    console.log('Pusher initialized successfully');
                } else {
                    console.log('Pusher is not enabled or configured');
                }
            })
            .catch(error => {
                console.error('Failed to initialize Pusher:', error);
            });
    }

    // Load notifications
    function loadNotifications() {
        fetch('/admin/api/notifications?limit=10')
            .then(response => response.json())
            .then(data => {
                renderNotifications(data.notifications);
                updateUnreadCount(data.unread_count);
            })
            .catch(error => {
                console.error('Failed to load notifications:', error);
                renderError();
            });
    }

    // Render notifications
    function renderNotifications(notifications) {
        const container = document.getElementById('notificationsContainer');
        
        if (!container) return;

        if (notifications.length === 0) {
            container.innerHTML = `
                <li class="flex items-center justify-center px-4 py-8">
                    <div class="text-center">
                        <i data-feather="bell-off" class="w-8 h-8 text-slate-300 dark:text-slate-600 mx-auto mb-2"></i>
                        <p class="text-sm text-slate-500 dark:text-slate-400">No notifications</p>
                    </div>
                </li>
            `;
            if (typeof feather !== 'undefined') feather.replace();
            return;
        }

        container.innerHTML = notifications.map(notification => `
            <li class="flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700 ${!notification.is_read ? 'bg-blue-50/50 dark:bg-blue-900/10' : ''}" 
                onclick="window.location.href='${notification.order_id ? '/admin/orders/' + notification.order_id : '#'}'">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full ${notification.icon_color_class}">
                    <i data-feather="${notification.icon}" width="20" height="20"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h6 class="text-sm font-normal ${!notification.is_read ? 'font-semibold' : ''}">
                        ${escapeHtml(notification.title)}
                        ${!notification.is_read ? '<span class="ml-1 inline-flex h-2 w-2 rounded-full bg-primary-500"></span>' : ''}
                    </h6>
                    <p class="text-xs text-slate-400 mt-1">${escapeHtml(notification.message)}</p>
                    <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                        <i data-feather="clock" width="1em" height="1em"></i>
                        <span>${notification.created_at}</span>
                    </p>
                </div>
            </li>
        `).join('');

        if (typeof feather !== 'undefined') feather.replace();
    }

    // Add notification to dropdown (for real-time)
    function addNotificationToDropdown(notification) {
        const container = document.getElementById('notificationsContainer');
        if (!container) return;

        // Remove empty state if exists
        const emptyState = container.querySelector('li:has([data-feather="bell-off"])');
        if (emptyState) emptyState.remove();

        // Create notification element
        const notificationEl = document.createElement('li');
        notificationEl.className = 'flex cursor-pointer gap-4 px-4 py-3 transition-colors duration-150 hover:bg-slate-100/70 dark:hover:bg-slate-700 bg-blue-50/50 dark:bg-blue-900/10';
        notificationEl.onclick = () => {
            if (notification.order_id) {
                window.location.href = '/admin/orders/' + notification.order_id;
            }
        };
        
        notificationEl.innerHTML = `
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full ${notification.icon_color_class}">
                <i data-feather="${notification.icon}" width="20" height="20"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h6 class="text-sm font-semibold">
                    ${escapeHtml(notification.title)}
                    <span class="ml-1 inline-flex h-2 w-2 rounded-full bg-primary-500"></span>
                </h6>
                <p class="text-xs text-slate-400 mt-1">${escapeHtml(notification.message)}</p>
                <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                    <i data-feather="clock" width="1em" height="1em"></i>
                    <span>Just now</span>
                </p>
            </div>
        `;

        // Insert at top
        container.insertBefore(notificationEl, container.firstChild);

        // Remove oldest if more than 10
        const items = container.querySelectorAll('li');
        if (items.length > 10) {
            items[items.length - 1].remove();
        }

        if (typeof feather !== 'undefined') feather.replace();
    }

    // Update unread count badge
    function updateUnreadCount(count) {
        unreadCount = count;
        const badge = document.getElementById('notificationBadge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }
    }

    // Show browser notification
    function showBrowserNotification(notification) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(notification.title, {
                body: notification.message,
                icon: '/favicon.ico',
                tag: 'order-notification-' + notification.id
            });
        }
    }

    // Request notification permission
    function requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    }

    // Render error state
    function renderError() {
        const container = document.getElementById('notificationsContainer');
        if (!container) return;

        container.innerHTML = `
            <li class="flex items-center justify-center px-4 py-8">
                <div class="text-center">
                    <i data-feather="alert-circle" class="w-8 h-8 text-red-400 mx-auto mb-2"></i>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Failed to load notifications</p>
                </div>
            </li>
        `;
        if (typeof feather !== 'undefined') feather.replace();
    }

    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Mark all as read
    function markAllAsRead() {
        fetch('/admin/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
            }
        })
        .catch(error => {
            console.error('Failed to mark all as read:', error);
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initPusher();
            loadNotifications();
            requestNotificationPermission();

            // Mark all as read button
            const markAllReadBtn = document.getElementById('markAllReadHeaderBtn');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    markAllAsRead();
                });
            }

            // Refresh notifications every 30 seconds
            setInterval(loadNotifications, 30000);
        });
    } else {
        initPusher();
        loadNotifications();
        requestNotificationPermission();

        const markAllReadBtn = document.getElementById('markAllReadHeaderBtn');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                markAllAsRead();
            });
        }

        setInterval(loadNotifications, 30000);
    }
})();

