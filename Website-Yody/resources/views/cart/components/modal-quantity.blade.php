<form action="{{ route('cart.update') }}" method="POST" class="updateCart" style="display:inline;">
    @csrf
    @method('PUT')
    @if(Auth::check())
            @foreach ($chiTietGioHang as $index => $chitiet)
            <div id="confirmModal-{{ $index }}" class=" fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity duration-300 ease-in-out">
                <div class="bg-white rounded-lg p-6 shadow-lg transform transition-transform duration-300 ease-in-out scale-90">
                    <p class="text-lg font-semibold mb-4 text-gray-800">Bạn có muốn xoá sản phẩm này không?</p>
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('cart.remove', ['MaGH' => $chitiet->MaGH, 'MaCTSP' => $chitiet->MaCTSP]) }}" class="remove-item">
                            <button type="button" class="confirmRemove bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 ease-in-out">Có</button>
                        </a>
                        <button type="button" class="cancelRemove bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200 ease-in-out">Không</button>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @foreach ($gioHangSession as $index => $item)
            <div id="confirmModal-{{ $index }}" class=" fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity duration-300 ease-in-out">
                <div class="bg-white rounded-lg p-6 shadow-lg transform transition-transform duration-300 ease-in-out scale-90">
                    <p class="text-lg font-semibold mb-4 text-gray-800">Bạn có muốn xoá sản phẩm này không?</p>
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('cart.removeSS', ['MaCTSP' => $item['MaCTSP']]) }}" class="remove-item">
                            <button type="button" class="confirmRemove bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200 ease-in-out">Có</button>
                        </a>
                        <button type="button" class="cancelRemove bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200 ease-in-out">Không</button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const incrementButtons = document.querySelectorAll('.increment');
        const decrementButtons = document.querySelectorAll('.decrement');
        
        let currentInput = null;  // Input hiện tại đang được thao tác
        let currentModal = null; // Lưu modal hiện tại để hiển thị

        function checkMaxQuantity(input) {
            let value = parseInt(input.value, 10);
            if (value > 100) {
                input.value = 100; // Giới hạn số lượng tối đa là 100
            }
        }

        incrementButtons.forEach(button => {
            button.addEventListener('click', function () {
                const index = button.getAttribute('data-index');
                const input = document.getElementById(`quantity-input-${index}`);
                let value = parseInt(input.value, 10);
                input.value = isNaN(value) ? 1 : value + 1;  // Đảm bảo giá trị tối thiểu là 1
                checkMaxQuantity(input);
            });
        });

        decrementButtons.forEach(button => {
            button.addEventListener('click', function () {
                const index = button.getAttribute('data-index');
                const input = document.getElementById(`quantity-input-${index}`);
                let value = parseInt(input.value, 10);
                if (isNaN(value) || value <= 1) {
                    currentInput = input;
                    currentModal = document.getElementById(`confirmModal-${index}`); // Lưu modal tương ứng
                    currentModal.classList.remove('hidden');
                    currentModal.classList.add('flex');  // Hiển thị modal
                } else {
                    input.value = value - 1;
                }
            });
        });

        // Lắng nghe sự kiện cho các nút xác nhận xóa và hủy
        document.querySelectorAll('.confirmRemove').forEach(button => {
            button.addEventListener('click', function () {
                const link = button.closest('a').getAttribute('href');
                window.location.href = link; // Điều hướng đến liên kết xoá
            });
        });

        document.querySelectorAll('.cancelRemove').forEach(button => {
            button.addEventListener('click', function () {
                if (currentInput) {
                    currentInput.value = 1; // Đặt lại giá trị về 1
                }
                if (currentModal) {
                    currentModal.classList.add('hidden');
                    setTimeout(() => {
                        currentModal.classList.remove('flex');
                    }, 300); 
                }
            });
        });
        
    });
</script>
