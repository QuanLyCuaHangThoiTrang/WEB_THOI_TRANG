@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 px-12 pb-10 mt-20">
        <section class="container mx-auto py-2 lg:py-4 bg-gray-100">       
                <div class="w-full max-w-7xl mx-auto relative z-10">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <!-- Product List -->
                        <div class="flex-1 lg:pr-8 pb-8 lg:py-4 w-full max-xl:max-w-3xl max-xl:mx-auto">                
                            <div class="flex flex-col bg-white px-7 py-5 border-b border-gray-200 gap-4 md:gap-4">
                                <div class="grid grid-cols-2 justify-between space-x-4">
                                    <form class="formabc" action="{{ route('checkout.applyVoucher') }}" method="POST">
                                        @csrf
                                        <div class="w-full">
                                            <div class="flex items-center justify-between border-t border-gray-200 py-4">
                                                <h3 class="text-lg font-bold text-gray-800">Giảm giá</h3>
                                                <div class="flex border overflow-hidden max-w-sm rounded-md">
                                                    <input type="text" name="voucher_code" placeholder="Nhập mã giảm giá"
                                                        class="w-full outline-none bg-white text-gray-600 uppercase text-sm px-2 py-2.5" />
                                                    <button type='submit' class="flex items-center justify-center bg-blue-800 px-5 text-sm text-white">
                                                        Apply
                                                    </button>
                                                </div>
                                            </div>
                                                <!-- Hiển thị thông báo lỗi -->
                                                    @if ($errors->has('voucher_code'))
                                                        <div class="mt-2 text-red-600 text-sm">
                                                            {{ $errors->first('voucher_code') }}
                                                        </div>
                                                    @endif                                     
                                        </div>
                                    </form>
                                    @if (session()->get('MaVC'))
                                    <form class="formabc" action="{{ route('voucher.cancel') }}" method="POST">
                                        @csrf
                                                        
                                        <div class="flex justify-end">
                                            <button type="submit" class="flex items-center justify-center bg-red-600 px-5 text-sm text-white">Hủy voucher</button>
                                        </div>
                                                               
                                    </form>
                                    @endif
                                </div>
                            </div>                            
                        </div>      
                    </div>
                </div>
        
            <form class="formabc" action="{{ route('checkout.processDH') }}" method="POST">
                @csrf
                <div class="w-full max-w-7xl mx-auto relative z-10">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <!-- Product List -->
                        <div class="flex-1 lg:pr-8 pb-8 lg:py-4 w-full max-xl:max-w-3xl max-xl:mx-auto">
                            <div class="flex bg-white justify-between items-center py-4 mb-2 rounded-md">
                                <h1 class="font-bold text-xl px-7">Người nhận</h1>
                            </div>
                            <div class="flex flex-col bg-white px-7 py-5 border-b border-gray-200 gap-4 md:gap-4">
                                <div class="grid grid-cols-2 justify-between space-x-4">
                                    <div class="mb-2">
                                        <div class="relative flex flex-col">
                                            <label for="full_name" class="mb-2 block text-sm font-medium text-gray-900"> Họ
                                                và tên </label>
                                            <input name="name" value="{{ Auth::check() ? Auth::user()->HoTen : '' }}"
                                                type="text" required
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                placeholder="Enter full name" />
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="relative flex flex-col">
                                            <label for="email" class="mb-2 block text-sm font-medium text-gray-900">
                                                Email </label>
                                            <input value="{{ Auth::check() ? Auth::user()->Email : '' }}" name="email"
                                                type="text" required
                                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                placeholder="Enter email" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-1 md:col-span-4 mb-0">
                                    <label for="diachi" class="mb-2 block text-sm font-medium text-gray-900"> Địa chỉ
                                    </label>
                                    <input type="text" id="diachi" name="diachinha" placeholder="Nhập địa chỉ"
                                        required
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" />
                                    <div id="diachiError" class="text-red-600 text-sm mt-1">
                                        {{ $errors->first('diachi') }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3 items-center justify-center">
                                    <div class="col-span-1">
                                        <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                                        <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                                        <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">
                                        <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-yellow-500 focus:ring-yellow-500" id="tinh" name="tinh" title="Chọn Tỉnh Thành">
                                            <option value="0">Tỉnh Thành</option>
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-yellow-500 focus:ring-yellow-500" id="quan" name="quan" title="Chọn Quận Huyện">
                                            <option value="0">Quận Huyện</option>
                                        </select>
                                    </div>
                                    <div class="col-span-1">
                                        <select class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-yellow-500 focus:ring-yellow-500" id="phuong" name="phuong" title="Chọn Phường Xã">
                                            <option value="0">Phường Xã</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-2 mb-2">
                                    <div class="relative flex flex-col justify-between">
                                        <label for="phone_number" class="mb-2 block text-sm font-medium text-gray-900"> Số
                                            điện thoại</label>
                                        <input value="{{ Auth::check() ? Auth::user()->SDT : '' }}" name="phone_number"
                                            type="text" required
                                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                            placeholder="Enter phone number" />
                                    </div>
                                </div>
                                <div>
                                    <label for="Message" class="mb-2 block text-sm font-medium text-gray-900"> Ghi
                                        chú</label>
                                    <textarea placeholder='Message' rows="6"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"></textarea>
                                </div>
                            </div>

                            <div
                                class="flex flex-col bg-white justify-between items-center py-4 mb-2 mt-2 rounded-md px-4 sm:px-6 md:px-8">
                                <h1 class="font-bold text-xl text-center sm:text-2xl md:text-3xl px-2">Phương thức thanh
                                    toán</h1>
                                <p class="text-sm text-center sm:text-base mt-2 px-2">Lựa chọn phương thức thanh toán phù
                                    hợp với bạn</p>
                            </div>

                            <div
                                class="flex flex-col text-md md:flex-row bg-white justify-center space-y-4 md:space-y-0 space-x-5 items-center py-5 border-b border-gray-200 gap-4">

                                <input type="radio" id="payment_cash" name="payment_method" class="color-radio hidden"
                                    value="Thanh toán tiền mặt">
                                <label for="payment_cash"
                                    class="h-48 w-full md:w-64 rounded-xl shadow hover:shadow-xl duration-150 hover:bg-white border flex flex-col items-center justify-center bg-gray-50 cursor-pointer">
                                    <img src="{{ asset('/icons/money.png') }}" class="w-24 h-24" alt="">
                                    <h1 class="mt-2 text-center">Thanh toán bằng tiền mặt</h1>
                                </label>

                                <input type="radio" id="payment_momo" name="payment_method" class="color-radio hidden"
                                    value="Thanh toán momo">
                                <label for="payment_momo"
                                    class="h-48 w-full md:w-64 rounded-xl shadow hover:shadow-xl duration-150 hover:bg-white border flex flex-col items-center justify-center bg-gray-50 cursor-pointer">
                                    <img src="{{ asset('/icons/momo.webp') }}" class="w-24 h-24" alt="">
                                    <h1 class="mt-2 text-center">Thanh toán bằng Momo</h1>
                                </label>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="w-full lg:w-[400px] bg-white mt-4 p-6 xl:p-10 max-w-3xl xl:max-w-lg mx-auto py-4">
                            <h2 class="font-semibold text-2xl leading-10 border-b border-gray-300 pb-2">Chi tiết đơn hàng
                            </h2>

                            <div class="mt-2 text-base">       
                                <div class="flex items-center justify-between pb-2">
                                    <p class="leading-8 text-gray-600">Tổng giá trị sản phẩm</p>
                                    <p class="leading-8 text-gray-600">{{ number_format($tongGiaTri, 0, ',', '.') }} đ</p>
                                </div>
                                <div class="flex items-center justify-between pb-2">
                                    <p class="leading-8 text-gray-600">Giảm giá:</p>
                                    <p class="leading-8 text-red-600">{{ number_format($giamGia, 0, ',', '.') }} đ</p>
                                </div>
                                <div class="flex items-center justify-between pb-2">
                                    <p class="leading-8 text-gray-600">Vận chuyển:</p>
                                    <p class="leading-8 text-gray-600">{{ number_format(20000, 0, ',', '.') }} đ</p>
                                </div>

                                <div class="flex font-semibold items-center border-t border-gray-200 justify-between py-4">
                                    <p class="text-xl leading-8">Tổng giá trị:</p>
                                    <p class="text-xl leading-8">{{ number_format($tongTien, 0, ',', '.') }} đ</p>
                                </div>

                                <button type="submit"
                                    class="w-full bg-yellow-500 rounded-xl py-3 px-6 font-semibold text-lg text-white transition-all duration-500 hover:bg-yellow-400 shadow-sm border-b-2 border-b-yellow-700 shadow-yellow-600">Thanh
                                    toán</button>

                                <div class="p-4 text-center mt-4">
                                    <div class="flex gap-2 items-center justify-center mb-3">
                                        @foreach (['zalopay', 'visa-card', 'master-card', 'vnpay-qr', 'momo'] as $icon)
                                            <img alt="{{ $icon }}" class="h-[1.5rem] object-contain"
                                                src="https://yody.vn/icons/{{ $icon }}.png">
                                        @endforeach
                                    </div>
                                    <div class="font-medium text-gray-600">Đảm bảo thanh toán an toàn và bảo mật</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

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