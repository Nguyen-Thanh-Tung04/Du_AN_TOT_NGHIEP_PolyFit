import "./bootstrap";
function timeSince(date) {
    const seconds = Math.floor((new Date() - new Date(date)) / 1000);
    let interval = Math.floor(seconds / 60);

    if (interval < 1) return 'Vừa mới';
    if (interval == 1) return '1 phút trước';
    return `${interval} phút trước`;
}

// Lắng nghe sự kiện 'order.placed'
window.Echo.channel('orders-channel')
    .listen('OrderPlaced', (e) => {
        const timeAgo = timeSince(e.order.created_at);

        let recentPurchaseHtml = `
            <div class="recent-purchase">
                <img src="/storage/${e.image}" alt="payment image">
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
    });