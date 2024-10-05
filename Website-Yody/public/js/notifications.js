setTimeout(() => {
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        notification.style.opacity = '0'; // Đặt độ mờ thành 0
        setTimeout(() => {
            notification.remove(); // Xóa thông báo khỏi DOM sau khi đã mờ
        }, 500); // Thời gian trễ trước khi xóa (trùng với thời gian mờ)
    });
}, 1500);