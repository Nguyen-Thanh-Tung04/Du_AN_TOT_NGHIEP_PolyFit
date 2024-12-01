function timeSince(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    const minutes = Math.floor(seconds / 60); // Tính theo phút

    if (minutes < 1) return 'Vừa mới';

    if (minutes < 60) return `${minutes} phút trước`;

    const hours = Math.floor(minutes / 60);
    const remainingMinutes = minutes % 60;
    if (remainingMinutes > 0) {
        return `${hours} giờ ${remainingMinutes} phút trước`;
    }
    return `${hours} giờ trước`;
}

// Lắng nghe sự kiện 'order.placed'
window.Echo.channel('orders-channel')
    .listen('OrderPlaced', (e) => {
        const timeAgo = timeSince(e.order.created_at);

        // Tạo HTML cho thông báo
        let recentPurchaseHtml = `
            <div class="recent-purchase" data-created-at="${e.order.created_at}">
                <img src="${e.image}" alt="payment image">
                <div class="detail">
                    <p>Có người mới mua</p>
                    <h6>${e.product_name}</h6>
                    <p class="time-ago">${timeAgo}</p>
                </div>
                <a href="javascript:void(0)" class="icon-btn recent-close">×</a>
            </div>`;

        // Thêm thông báo mới vào container
        document.querySelector('.recent-purchase-container').innerHTML += recentPurchaseHtml;

        // Lắng nghe sự kiện đóng thông báo
        document.querySelectorAll('.recent-close').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.target.closest('.recent-purchase').remove();
            });
        });
    });

// Cập nhật thời gian trôi qua cho các thông báo mỗi phút
setInterval(function () {
    const allNotifications = document.querySelectorAll('.recent-purchase');
    
    allNotifications.forEach(notification => {
        const createdAt = notification.getAttribute('data-created-at');
        const timeAgo = timeSince(createdAt);
        
        // Cập nhật lại thời gian đã trôi qua
        notification.querySelector('.time-ago').innerText = timeAgo;
    });
}, 60000); // Cập nhật mỗi 60 giây (1 phút)
