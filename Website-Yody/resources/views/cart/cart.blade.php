@extends('layouts.app')

@section('content')
    <div class=" px-10  pb-10 font-plus-jakara fade-in min-h-screen">
        <section class="container mt-20 mx-auto py-2 lg:py-4">
            @include('cart.components.cart-list')
        </section>
    </div>
@section('scripts')
    <script>
        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.dataset.index;
                const input = document.getElementById(`quantity-input-${index}`);
                let value = parseInt(input.value);
                if (!isNaN(value)) {
                    value++;
                    input.value = value;
                }
            });
        });

        document.querySelectorAll('.decrement').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.dataset.index;
                const input = document.getElementById(`quantity-input-${index}`);
                let value = parseInt(input.value);
                if (!isNaN(value) && value > 1) {
                    value--;
                    input.value = value;
                }
            });
        });
    </script>
    <script>
        // Hàm kiểm tra số lượng và ẩn nút checkout nếu cần
        function checkQuantity(index) {
            const quantityInput = document.getElementById(`quantity-input-${index}`);
            const stockQuantity = parseInt(document.getElementById(`SoLuongKho-${index}-SoLuongTonKho`).innerText);
            const checkoutButton = document.getElementById('checkout-button');
            console.log(123);
            // Lấy số lượng đã nhập
            let enteredQuantity = parseInt(quantityInput.value);

            // Kiểm tra nếu số lượng nhập vượt quá số lượng kho
            if (enteredQuantity > stockQuantity) {
                // Ẩn nút "Hoàn tất kiểm tra"
                checkoutButton.style.display = 'none';
            } else {
                // Hiển thị lại nút nếu số lượng hợp lệ
                checkoutButton.style.display = 'block';
            }
        }
    </script>
@endsection
@endsection
