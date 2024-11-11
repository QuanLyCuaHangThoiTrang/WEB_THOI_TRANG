<!-- Nút mở Modal -->
<div class="fixed bottom-24 right-[35px] z-50">
    <button onclick="openModal()"
        class="bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:scale-110 transition duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
                d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z" />
        </svg>
        <span id="notification-count" class="absolute top-[-15px] right-[-8px] bg-red-500 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
            @php
            $totalProducts = 0;
            foreach ($KhuyenMais as $KhuyenMai) {
                $totalProducts += $KhuyenMai->sanPhamKhuyenMais->count();
            }
            @endphp
            {{ $totalProducts }}
        </span>
    </button>
</div>

<!-- Modal Notification -->
<div id="notificationModal"
    class="fixed top-1/4 right-0 z-50 mr-5 hidden sm:w-80 md:w-96 transition-all duration-300 opacity-0 transform translate-x-full">
    <div class="bg-white rounded-lg shadow-xl p-6 relative max-h-[90vh] overflow-y-auto">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">
            &times;
        </button>
        <h2 class="text-2xl font-bold mb-4 text-center text-blue-600">Thông báo</h2>
        @foreach ($KhuyenMais as $KhuyenMai)
            <div class="mb-4">
                <p class="text-lg font-semibold text-gray-800">{{ $KhuyenMai->TenKM }}</p>
                @foreach ($KhuyenMai->sanPhamKhuyenMais as $SanPhamKhuyenMai)
                    <p class="text-sm text-gray-600 flex items-center">
                        <a href="{{ url('/product_detail/' . $SanPhamKhuyenMai->SanPham->MaSP) }}" class="hover:text-blue-500 transition-colors">
                            {{ $SanPhamKhuyenMai->SanPham->TenSP }}
                        </a>
                        <span class="ml-2 px-2 py-1 text-xs font-bold text-white bg-red-500 rounded-full mt-1">
                            -{{ round($KhuyenMai->PhanTramGiamGia) }}%
                        </span>
                    </p>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<script>
    let closeModalTimeout;

    function openModal() {
        const modal = document.getElementById('notificationModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0', 'translate-x-full');
            modal.classList.add('opacity-100', 'translate-x-0');
        }, 10); // Đảm bảo transition được kích hoạt
        closeModalTimeout = setTimeout(closeModal, 10000); // Đóng modal sau 10s
    }

    function closeModal() {
        const modal = document.getElementById('notificationModal');
        modal.classList.add('opacity-0', 'translate-x-full');
        modal.classList.remove('opacity-100', 'translate-x-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // Thời gian chờ để transition kết thúc
        clearTimeout(closeModalTimeout);
    }

    window.onclick = function(event) {
        const modal = document.getElementById('notificationModal');
        if (event.target === modal) {
            closeModal();
        }
    };
</script>
