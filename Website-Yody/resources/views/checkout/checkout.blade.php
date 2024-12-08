@php
    // Define translations for both languages
    $commonData = [
        'en' => [
            'checkout' => 'CHECKOUT',
            'placehoder_checkout' => 'Voucher code',
            'apply' => 'Apply',
            'cancel' => 'Cancel',
            'close' => 'Close',
            'recipient' => 'RECIPIENT',
            'name' => 'Full name',
            'placeholder_name' => 'Enter full name',
            'placeholder_email' => 'Enter email',
            'phone_number' => 'Phone number',
            'placeholder_phone_number' => 'Enter phone number',
            'address' => 'Address', // Fixed duplicate key 'address'
            'new_address' => 'New Address',
            'notes' => 'Notes',
            'placeholder_address' => 'Enter address',
            'placeholder_notes' => 'Enter note',
            'province' => 'Province',
            'district' => 'District',
            'ward' => 'Ward',
            'placeholder_province' => 'Select province',
            'placeholder_district' => 'Select district',
            'placeholder_ward' => 'Select ward',
            'order_detail' => 'Order details',
            'total' => 'Total',
            'sale' => 'Sale off',
            'shipping' => 'Shipping',
            'payment' => 'Payment',
            'payment_select' => 'Select your payment method',
            'cash' => 'by Cash',
            'momo' => 'Momo',
            'complete' => 'Complete',
            'enter_code' => 'Enter your voucher code',
        ],
        'vi' => [
            'checkout' => 'THANH TOÁN',
            'placehoder_checkout' => 'Mã giảm giá',
            'apply' => 'Áp dụng',
            'cancel' => 'Hủy',
            'close' => 'Đóng',
            'recipient' => 'NGƯỜI NHẬN',
            'name' => 'Họ và tên',
            'placeholder_name' => 'Nhập họ và tên',
            'placeholder_email' => 'Nhập email',
            'phone_number' => 'Số điện thoại',
            'placeholder_phone_number' => 'Nhập số điện thoại',
            'address' => 'Địa chỉ', // Fixed duplicate key 'address'
            'new_address' => 'Địa chỉ mới',
            'notes' => 'Ghi chú',
            'placeholder_address' => 'Nhập địa chỉ',
            'placeholder_notes' => 'Nội dung',
            'province' => 'Tỉnh/Thành phố',
            'district' => 'Quận/Huyện',
            'ward' => 'Phường/Xã',
            'placeholder_province' => 'Chọn tỉnh/thành phố',
            'placeholder_district' => 'Chọn quận/huyện',
            'placeholder_ward' => 'Chọn Phường/xã',
            'order_detail' => 'Chi tiết đơn hàng',
            'total' => 'Tổng giá trị',
            'sale' => 'Giảm giá',
            'shipping' => 'Phí vận chuyển',
            'payment' => 'Phương thức thanh toán',
            'payment_select' => 'Lựa chọn phương thức thanh toán',
            'cash' => 'Tiền mặt',
            'momo' => 'Momo',
            'complete' => 'Hoàn thành thanh toán',
            'enter_code' => 'Nhập mã giảm giá',
        ],
    ];

    // Get the current language code
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp

@extends('layouts.app')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const voucherModal = document.getElementById('voucherModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const applyBtn = document.getElementById('applyBtn');
        const voucherForm = document.querySelector('.formabc');

        // Mở modal khi click vào nút "Nhập mã giảm giá"
        openModalBtn.addEventListener('click', function(event) {
            event.preventDefault();
            voucherModal.classList.remove('hidden');

            // Kiểm tra trạng thái khi mở lại modal
            if ({{ session('success') ? 'true' : 'false' }}) {
                applyBtn.textContent = '{{ $selectedData['cancel'] }}';
                applyBtn.classList.remove('bg-blue-800', 'hover:bg-blue-700');
                applyBtn.classList.add('bg-red-700', 'hover:bg-red-600');
                voucherForm.action = "{{ route('voucher.cancel', ['locale' => app()->getLocale()]) }}";

            } else {
                applyBtn.textContent = '{{ $selectedData['apply'] }}';
                applyBtn.classList.remove('bg-red-700', 'hover:bg-red-600');
                applyBtn.classList.add('bg-blue-800', 'hover:bg-blue-700');
                voucherForm.action =
                    "{{ route('checkout.applyVoucher', ['locale' => app()->getLocale()]) }}";
            }
        });

        // Đóng modal khi click vào nút "Đóng"
        closeModalBtn.addEventListener('click', function() {
            voucherModal.classList.add('hidden');
        });

        // Đóng modal khi click ra ngoài vùng modal
        window.addEventListener('click', function(event) {
            if (event.target === voucherModal) {
                voucherModal.classList.add('hidden');
            }
        });
    });
</script>



@section('content')
    @if (session('updateInterface'))
        <script>
            window.location.reload();
        </script>
    @endif
    <div class=" px-12 pb-5 mt-20">
        <section class="container z-50  mx-auto py-2">
            <div class=" py-5 border-b">
                <p class="text-3xl font-bold ">{{ $selectedData['checkout'] }}</p>
            </div>
            <div class="w-full max-w-8xl mx-auto relative z-10">
                <div class="modal fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden"
                    id="voucherModal">
                    <div class="bg-white rounded-lg w-96 p-6">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">{{ $selectedData['placehoder_checkout'] }}</h2>
                        <form class="formabc"
                            action="{{ session('success') ? route('voucher.cancel', ['locale' => app()->getLocale()]) : route('checkout.applyVoucher', ['locale' => app()->getLocale()]) }}"
                            method="POST">
                            @csrf
                            <div class="w-full mb-4">
                                <input type="text" name="voucher_code" placeholder="{{ $selectedData['enter_code'] }}"
                                    value="{{ old('voucher_code', session('MaVC', '')) }}"
                                    class="w-full outline-none bg-gray-100 text-gray-600 uppercase text-sm px-4 py-2 border border-gray-300 rounded-md" />
                            </div>
                            <button type="submit" id="applyBtn"
                                class="w-full bg-blue-800 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                {{ $selectedData['apply'] }}
                            </button>
                        </form>

                        <button class=" w-full bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md"
                            id="closeModalBtn">{{ $selectedData['close'] }}</button>
                    </div>
                </div>

            </div>
    </div>
    @if (session('success'))
        <div
            class="notification absolute z-30 top-24 right-10 bg-green-400 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif
    <!-- Hiển thị thông báo lỗi -->
    @if ($errors->has('voucher_code'))
        <div
            class="notification absolute z-30 top-24 right-10 bg-red-400 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
            {{ $errors->first('voucher_code') }}
        </div>
    @endif

    <form class="formabc" action="{{ route('checkout.processDH', ['locale' => app()->getLocale()]) }}" method="POST">
        @csrf
        @if ($errors->any())
            <div
                class="notification absolute z-30 top-24 right-10 bg-red-500 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <div class="w-full mb-24 max-w-7xl mx-auto relative">
            <div class="flex flex-col lg:flex-row gap-4">

                <!-- Product List -->
                <div class="flex-1  lg:pr-8 pb-3 lg:py-4 w-full max-xl:max-w-3xl max-xl:mx-auto">
                    <div class="flex bg-white border-b justify-between items-center py-4">
                        <h1 class="font-bold text-2xl px-7">{{ $selectedData['recipient'] }}</h1>
                    </div>
                    <div class="flex flex-col bg-white px-7 py-5 border-b border-gray-200 gap-4 md:gap-6">
                        <!-- Họ và tên, Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="full_name"
                                    class="block text-sm font-medium text-gray-900">{{ $selectedData['name'] }}</label>
                                <input name="name" value="{{ Auth::check() ? Auth::user()->HoTen : '' }}" type="text"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500"
                                    placeholder="{{ $selectedData['placeholder_name'] }}" />
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                                <input value="{{ Auth::check() ? Auth::user()->Email : '' }}" name="email" type="text"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500"
                                    placeholder="{{ $selectedData['placeholder_email'] }}" />
                            </div>
                        </div>

                        <!-- Địa chỉ -->
                        <div>
                            <label for="diachi"
                                class="block text-sm font-medium text-gray-900">{{ $selectedData['address'] }}</label>

                            @if (Auth::check())
                                <div>
                                    <select id="existingAddress" name="diachifull"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 outline-none"
                                        title="Chọn Tỉnh Thành">
                                        @foreach ($diaChiFulls as $diaChiFull)
                                            <option value="{{ $diaChiFull->MaDC }}">{{ $diaChiFull->Duong }},
                                                {{ $diaChiFull->Phuong }}, {{ $diaChiFull->Huyen }},
                                                {{ $diaChiFull->Tinh }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <label for="addNewAddress" class="inline-flex items-center">
                                        <input type="checkbox" id="addNewAddress" class="mr-2"
                                            onclick="toggleNewAddressInput()">
                                        <span class="text-sm text-gray-700">{{ $selectedData['new_address'] }}</span>
                                    </label>
                                </div>
                            @else
                                <input type="text" id="diachi" name="diachinha"
                                    placeholder="{{ $selectedData['placeholder_address'] }}"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" />
                                <div id="diachiError" class="text-red-600 text-sm mt-1">
                                    {{ $errors->first('diachi') }}
                                </div>
                            @endif
                            @if (Auth::check())
                                <div id="newAddressContainer" class="mt-2 hidden">
                                    <input type="text" id="newAddress" name="newAddress"
                                        placeholder="{{ $selectedData['placeholder_address'] }}"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500" />
                                    <div id="newAddressError" class="text-red-600 text-sm mt-1 mb-4"></div>


                                    <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                                    <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                                    <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <select
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 outline-none"
                                                id="tinh" name="tinh" title="Chọn Tỉnh Thành" required>
                                                <option value="0">{{ $selectedData['placeholder_province'] }}</option>
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 outline-none"
                                                id="quan" name="quan" title="Chọn Quận Huyện" required>
                                                <option value="0">{{ $selectedData['placeholder_district'] }}
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <select
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 outline-none"
                                                id="phuong" name="phuong" title="Chọn Phường Xã" required>
                                                <option value="0">{{ $selectedData['placeholder_ward'] }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <script>
                            function toggleNewAddressInput() {
                                const newAddressContainer = document.getElementById('newAddressContainer');
                                const existingAddressSelect = document.getElementById('existingAddress');
                                if (document.getElementById('addNewAddress').checked) {
                                    newAddressContainer.classList.remove('hidden');
                                    existingAddressSelect.value = ''; // Clear existing address selection
                                } else {
                                    newAddressContainer.classList.add('hidden');
                                }
                            }
                        </script>


                        @if (!Auth::check())
                            <!-- Chọn tỉnh, quận, phường -->
                            <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                            <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                            <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <select
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900  outline-none"
                                        id="tinh" name="tinh" title="Chọn Tỉnh Thành">
                                        <option value="0">{{ $selectedData['placeholder_province'] }}</option>
                                    </select>
                                </div>
                                <div>
                                    <select
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900  outline-none"
                                        id="quan" name="quan" title="Chọn Quận Huyện">
                                        <option value="0">{{ $selectedData['placeholder_district'] }}</option>
                                    </select>
                                </div>
                                <div>
                                    <select
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900  outline-none"
                                        id="phuong" name="phuong" title="Chọn Phường Xã">
                                        <option value="0">{{ $selectedData['placeholder_ward'] }}</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        <!-- Số điện thoại -->
                        <div>
                            <label for="phone_number"
                                class="block text-sm font-medium text-gray-900">{{ $selectedData['phone_number'] }}</label>
                            <input value="{{ Auth::check() ? Auth::user()->SDT : '' }}" name="phone_number"
                                type="text"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500"
                                placeholder="{{ $selectedData['placeholder_phone_number'] }}" />
                        </div>

                        <!-- Ghi chú -->
                        <div>
                            <label for="Message"
                                class="block text-sm font-medium text-gray-900">{{ $selectedData['notes'] }}</label>
                            <textarea name="Message" placeholder="{{ $selectedData['placeholder_notes'] }}" rows="6"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500"></textarea>
                        </div>

                    </div>



                </div>

                <!-- Order Summary -->
                <div class="w-full lg:w-[400px] bg-white p-6 xl:p-10 max-w-3xl xl:max-w-lg mx-auto py-4 border ">
                    <!-- Tiêu đề -->
                    <h2 class="font-semibold text-2xl leading-10 border-b border-gray-300 pb-2">
                        {{ $selectedData['order_detail'] }}</h2>

                    <!-- Thông tin đơn hàng -->
                    <div class="mt-2 text-base space-y-2">
                        {{-- <div class="flex items-center justify-between">
                            <p class="leading-8 text-gray-600">{{ $selectedData['total'] }}</p>
                            <p class="leading-8 text-gray-600">{{ number_format($tongGiaTri, 0, ',', '.') }} đ</p>
                        </div> --}}
                        <div class="flex items-center justify-between">
                            <p class="leading-8 text-gray-600">{{ $selectedData['sale'] }}</p>
                            <p class="leading-8 text-red-600">{{ number_format($giamGia, 0, ',', '.') }} đ</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="leading-8 text-gray-600">{{ $selectedData['shipping'] }}</p>
                            <p class="leading-8 text-gray-600">{{ number_format($PhiShip, 0, ',', '.') }} đ</p>
                        </div>
                        <div class="flex font-semibold items-center border-t border-gray-200 justify-between py-4">
                            <p class="text-xl leading-8">{{ $selectedData['total'] }}</p>
                            <p class="text-xl leading-8">{{ number_format($tongTien, 0, ',', '.') }} đ</p>
                        </div>

                    </div>
                    <div class="mt-2 text-base text-center">
                        <button id="openModalBtn"
                            class=" bg-black hover:bg-gray-800 duration-300 text-white w-full rounded-full py-2">
                            {{ $selectedData['enter_code'] }}
                        </button>
                    </div>

                    <!-- Phương thức thanh toán -->
                    <div class="bg-white py-4 mt-6 border-t text-center">
                        <h1 class="font-bold text-xl sm:text-2xl">{{ $selectedData['payment'] }}</h1>
                        <p class="text-sm sm:text-base mt-2 text-gray-500">{{ $selectedData['payment_select'] }}
                        </p>

                    </div>
                    <div
                        class="flex flex-col text-md md:flex-row bg-white justify-center space-y-4 md:space-y-0 space-x-5 items-center py-5 border-b border-gray-200 gap-4">

                        <input type="radio" id="payment_cash" name="payment_method" class="color-radio hidden"
                            value="Thanh toán tiền mặt" checked>
                        <label for="payment_cash"
                            class="h-48 w-full md:w-64 rounded-xl shadow hover:shadow-xl duration-150 hover:bg-white border flex flex-col items-center justify-center bg-gray-50 cursor-pointer">
                            <img src="{{ asset('/icons/money.png') }}" class="w-24 h-24" alt="">
                            <h1 class="mt-2 text-center">{{ $selectedData['cash'] }}</h1>
                        </label>

                        <input type="radio" id="payment_momo" name="payment_method" class="color-radio hidden"
                            value="Thanh toán momo">
                        <label for="payment_momo"
                            class="h-48 w-full md:w-64 rounded-xl shadow hover:shadow-xl duration-150 hover:bg-white border flex flex-col items-center justify-center bg-gray-50 cursor-pointer">
                            <img src="{{ asset('/icons/momo.webp') }}" class="w-24 h-24" alt="">
                            <h1 class="mt-2 text-center">{{ $selectedData['momo'] }}</h1>
                        </label>
                    </div>
                    <!-- Nút thanh toán -->
                    <button type="submit"
                        class="w-full mt-6 bg-yellow-500 rounded-xl py-3 px-6 font-semibold text-lg text-white transition-all duration-500 hover:bg-yellow-400 shadow-lg">
                        {{ $selectedData['complete'] }}
                    </button>
                </div>

            </div>
        </div>
    </form>
    </section>
    </div>
@endsection
<script src="{{ asset('js/notifications.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.querySelectorAll('.payment-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            const selectedPayment = this.value;
            document.getElementById('selected_payment_method').value = selectedPayment;
        });
    });
    $(document).ready(function() {
        //Lấy tỉnh thành
        $.getJSON('https://esgoo.net/api-tinhthanh/1/0.htm', function(data_tinh) {
            if (data_tinh.error === 0) {
                $.each(data_tinh.data, function(key_tinh, val_tinh) {
                    $("#tinh").append('<option value="' + val_tinh.id + '">' + val_tinh
                        .full_name + '</option>');
                });
                $("#tinh").change(function(e) {
                    var idtinh = $(this).val();
                    var tenTinh = $("#tinh option:selected").text(); // Lấy tên tỉnh được chọn
                    $("#hidden_tinh").val(
                        tenTinh
                    ); // Đặt giá trị của trường ẩn để gửi tên tỉnh về server           
                    //Lấy quận huyện
                    $.getJSON('https://esgoo.net/api-tinhthanh/2/' + idtinh + '.htm', function(
                        data_quan) {
                        if (data_quan.error === 0) {
                            $("#quan").html('<option value="0">Quận Huyện</option>');
                            $("#phuong").html('<option value="0">Phường Xã</option>');
                            $.each(data_quan.data, function(key_quan, val_quan) {
                                $("#quan").append('<option value="' + val_quan
                                    .id + '">' + val_quan.full_name +
                                    '</option>');
                            });
                        }
                    });
                });
            }
        });

        //Lấy phường xã khi chọn quận huyện
        $("#quan").change(function(e) {
            var idquan = $(this).val();
            var tenQuan = $("#quan option:selected").text(); // Lấy tên quận huyện được chọn
            $("#hidden_quan").val(tenQuan); // Đặt giá trị của trường ẩn để gửi tên quận huyện về server

            $.getJSON('https://esgoo.net/api-tinhthanh/3/' + idquan + '.htm', function(data_phuong) {
                if (data_phuong.error === 0) {
                    $("#phuong").html('<option value="0">Phường Xã</option>');
                    $.each(data_phuong.data, function(key_phuong, val_phuong) {
                        $("#phuong").append('<option value="' + val_phuong.id + '">' +
                            val_phuong.full_name + '</option>');
                    });
                }
            });
            console.log(tenQuan);
        });
        // Lấy phường xã khi chọn phường xã
        $("#phuong").change(function(e) {
            var tenPhuong = $("#phuong option:selected").text(); // Lấy tên phường xã được chọn
            $("#hidden_phuong").val(
                tenPhuong); // Đặt giá trị của trường ẩn để gửi tên phường xã về server
            console.log(tenPhuong);
        });
        $('form').submit(function(e) {
            console.log('Hidden Tinh:', $('#hidden_tinh').val());
            // Có thể thêm các kiểm tra giá trị tại đây
        });
    });
</script>
<script>
    function toggleNewAddressInput() {
        const checkbox = document.getElementById('addNewAddress');
        const newAddressContainer = document.getElementById('newAddressContainer');

        if (checkbox.checked) {
            newAddressContainer.classList.remove('hidden');
            document.getElementById('existingAddress').value = ""; // Clear selected option
        } else {
            newAddressContainer.classList.add('hidden');
            document.getElementById('newAddress').value = ""; // Clear new address input
        }
    }
</script>
