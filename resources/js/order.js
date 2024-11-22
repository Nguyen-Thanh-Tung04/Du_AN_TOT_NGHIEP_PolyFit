function timeSince(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);

    let interval = Math.floor(seconds / 3600); // Tính theo giờ
    if (interval >= 1) {
        const minutes = Math.floor((seconds % 3600) / 60); // Tính số phút còn lại
        if (minutes > 0) {
            return `${interval} giờ ${minutes} phút trước`;
        }
        return `${interval} giờ trước`;
    }

    interval = Math.floor(seconds / 60); // Tính theo phút
    if (interval >= 1) return `${interval} phút trước`;

    return 'Vừa mới';
}

// Lắng nghe sự kiện 'order.placed'
window.Echo.channel('orders-channel')
    .listen('OrderPlaced', (e) => {
        const timeAgo = timeSince(e.order.created_at);

        let recentPurchaseHtml = `
            <div class="recent-purchase">
                <img src="${e.image}" alt="payment image">
                <div class="detail">
                    <p>Có người mới mua</p>
                    <h6>${e.product_name}</h6>
                    <p>${timeAgo}</p>
                </div>
                <a href="javascript:void(0)" class="icon-btn recent-close">×</a>
            </div>`;
        // Console log thông tin trước khi hiển thị
        console.log('Sự kiện đơn hàng mới:', {
            product_name: e.product_name,
            image: e.image,
            created_at: e.order.created_at,
            timeAgo: timeAgo
        });

        document.querySelector('.recent-purchase-container').innerHTML = recentPurchaseHtml;
        setTimeout(function () {
            $(".recent-purchase").stop().slideToggle('slow');
        }, 8000);
    });
