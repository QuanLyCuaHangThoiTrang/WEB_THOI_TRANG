@extends('layouts.app')

@section('content')
<div class="bg-gray-100 px-12 pb-10">
    <section class="container mx-auto py-2 lg:py-4 bg-gray-100">
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
                                    <label for="full_name" class="mb-2 block text-sm font-medium text-gray-900"> Họ và tên </label>
                                    <input name="name" value="{{ Auth::check() ? Auth::user()->HoTen : '' }}" type="text" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Enter full name" />
                                </div>
                            </div>
                            <div class="mb-2">
                            <div class="relative flex flex-col">
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-900"> Email </label>
                                <input value="{{ Auth::check() ? Auth::user()->Email : '' }}" name="email" type="text" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Enter email" />
                            </div>
                        </div>
                        </div>

                        <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                        <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                        <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">

                        <div class="col-span-1 md:col-span-4 mb-0">
                        <label for="diachi" class="mb-2 block text-sm font-medium text-gray-900"> Địa chỉ </label>
                            <input 
                                type="text" 
                                id="diachi" 
                                name="diachinha" 
                                placeholder="Nhập địa chỉ" 
                                required 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            />
                            <div id="diachiError" class="text-red-600 text-sm mt-1">
                                {{ $errors->first('diachi') }}
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 items-center justify-center">
                        <!-- Input for address -->
                        <!-- Select for Tỉnh -->
                        <div class="col-span-1">
                            <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                            <label for="tinh" class="mb-2 block text-sm font-medium text-gray-900"> Tỉnh </label>
                            <select 
                                id="tinh" 
                                name="tinh" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn tỉnh</option>
                                <!-- populate options with data from your database or API -->
                            </select>
                        </div>

                        <!-- Select for Quận/Huyện -->
                        <div class="col-span-1">
                            <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                            <label for="quan" class="mb-2 block text-sm font-medium text-gray-900"> Quận/Huyện </label>
                            <select 
                                id="quan" 
                                name="quan" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn quận/huyện</option>
                            </select>
                        </div>

                        <!-- Select for Xã/Phường -->
                        <div class="col-span-1">
                            <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="hidden_phuong">
                            <label for="phuong" class="mb-2 block text-sm font-medium text-gray-900"> Phường/Xã</label>
                            <select 
                                id="phuong" 
                                name="phuong" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn xã/phường</option>
                            </select>
                        </div>
                    
                    </div>
                    
                    <div class="mt-2 mb-2">
                            <div class="relative flex flex-col justify-between">
                            <label for="phone_number" class="mb-2 block text-sm font-medium text-gray-900"> Số điện thoại</label>
                                <input value="{{ Auth::check() ? Auth::user()->SDT : '' }}" name="phone_number" type="text" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Enter phone number" />
                            </div>
                        </div>

                    <div>
                    <label for="Message" class="mb-2 block text-sm font-medium text-gray-900"> Ghi chú</label>
                        <textarea placeholder='Message' rows="6"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"></textarea>
                        </div>
                        </div>

                        <div class="flex flex-col bg-white justify-between items-center py-4 mb-2 mt-2 rounded-md px-4 sm:px-6 md:px-8">
                            <h1 class="font-bold text-xl text-center sm:text-2xl md:text-3xl px-2">Phương thức thanh toán</h1>
                            <p class="text-sm text-center sm:text-base mt-2 px-2">Lựa chọn phương thức thanh toán phù hợp với bạn</p>
                        </div>

                        <div class="flex flex-col text-md md:flex-row bg-white justify-center space-y-4 md:space-y-0 space-x-5 items-center py-5 border-b border-gray-200 gap-4">
                         
                            <input type="radio" id="payment_cash" name="payment_method" class="color-radio hidden" value="Thanh toán tiền mặt">
                            <label for="payment_cash" class="h-48 w-full md:w-64 rounded-xl shadow hover:shadow-xl duration-150 hover:bg-white border flex flex-col items-center justify-center bg-gray-50 cursor-pointer">
                                <img src="{{ asset('/icons/money.png') }}" class="w-24 h-24" alt="">
                                <h1 class="mt-2 text-center">Thanh toán bằng tiền mặt</h1>
                            </label>

                            <input type="radio" id="payment_momo" name="payment_method" class="color-radio hidden" value="Thanh toán momo">
                            <label for="payment_momo" class="h-48 w-full md:w-64 rounded-xl shadow hover:shadow-xl duration-150 hover:bg-white border flex flex-col items-center justify-center bg-gray-50 cursor-pointer">
                                <img src="{{ asset('/icons/momo.webp') }}" class="w-24 h-24" alt="">
                                <h1 class="mt-2 text-center">Thanh toán bằng Momo</h1>
                            </label>
                        </div>
                    </div>
    
                    <!-- Order Summary -->
                    <div class="w-full lg:w-[400px] bg-white mt-4 p-6 xl:p-10 max-w-3xl xl:max-w-lg mx-auto py-4">
                        <h2 class="font-semibold text-2xl leading-10 border-b border-gray-300 pb-2">Chi tiết đơn hàng</h2>
                        
                        <div class="mt-2 text-base">
                            <div class="flex items-center justify-between pb-2">
                                <p class="leading-8 text-gray-600">Tổng giá trị sản phẩm</p>
                                <p class="leading-8 text-gray-600">{{ $tongTien }}</p>
                            </div>
                            <div class="flex items-center justify-between pb-2">
                                <p class="leading-8 text-gray-600">Giảm giá:</p>
                                <p class="leading-8 text-red-600">-20.000đ</p>
                            </div>
                            <div class="flex items-center justify-between pb-2">
                                <p class="leading-8 text-gray-600">Vận chuyển:</p>
                                <p class="leading-8 text-gray-600">20.000đ</p>
                            </div>                   
                        
                                <div class="flex font-semibold items-center border-t border-gray-200 justify-between py-4">
                                    <p class="text-xl leading-8">Tổng giá trị:</p>
                                    <p class="text-xl leading-8">{{ $tongTien }}</p>
                                </div>
                              
                                    <button type="submit" class="w-full bg-yellow-500 rounded-xl py-3 px-6 font-semibold text-lg text-white transition-all duration-500 hover:bg-yellow-400 shadow-sm border-b-2 border-b-yellow-700 shadow-yellow-600">Thanh toán</button>
                         
                            <div class="p-4 text-center mt-4">
                                <div class="flex gap-2 items-center justify-center mb-3">
                                    @foreach(['zalopay', 'visa-card', 'master-card', 'vnpay-qr', 'momo'] as $icon)
                                        <img alt="{{ $icon }}" class="h-[1.5rem] object-contain" src="https://yody.vn/icons/{{ $icon }}.png">
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.querySelectorAll('.payment-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            const selectedPayment = this.value;
            document.getElementById('selected_payment_method').value = selectedPayment;
        });
    });
    $(document).ready(function() {
        //Lấy tỉnh thành
        $.getJSON('https://esgoo.net/api-tinhthanh/1/0.htm', function(data_tinh) {
            if (data_tinh.error === 0) {
                $.each(data_tinh.data, function(key_tinh, val_tinh) {
                    $("#tinh").append('<option value="' + val_tinh.id + '">' + val_tinh.full_name + '</option>');
                });
                $("#tinh").change(function(e) {
                    var idtinh = $(this).val();
                    var tenTinh = $("#tinh option:selected").text(); // Lấy tên tỉnh được chọn
                    $("#hidden_tinh").val(tenTinh); // Đặt giá trị của trường ẩn để gửi tên tỉnh về server
                    
                    //Lấy quận huyện
                    $.getJSON('https://esgoo.net/api-tinhthanh/2/' + idtinh + '.htm', function(data_quan) {
                        if (data_quan.error === 0) {
                            $("#quan").html('<option value="0">Quận Huyện</option>');
                            $("#phuong").html('<option value="0">Phường Xã</option>');
                            $.each(data_quan.data, function(key_quan, val_quan) {
                                $("#quan").append('<option value="' + val_quan.id + '">' + val_quan.full_name + '</option>');
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
                        $("#phuong").append('<option value="' + val_phuong.id + '">' + val_phuong.full_name + '</option>');
                    });
                }
            });
        });
        // Lấy phường xã khi chọn phường xã
        $("#phuong").change(function(e) {
            var tenPhuong = $("#phuong option:selected").text(); // Lấy tên phường xã được chọn
            $("#hidden_phuong").val(tenPhuong); // Đặt giá trị của trường ẩn để gửi tên phường xã về server
        });
    }); 
</script>
@endsection
