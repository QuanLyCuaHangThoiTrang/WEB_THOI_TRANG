@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <!-- Filter Dialog -->
    <div id="canvas-filter" class="fixed inset-0 z-50 lg:hidden hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>
        <div class="fixed inset-0 z-50 flex">
            <div class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-6 pb-12 shadow-xl rounded-lg">
                <div class="flex items-center justify-between px-6">
                    <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                    <button class="focus:outline-none" id="close-filter">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-gray-900 transition duration-150">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form class="mt-4 border-t border-gray-200">
                    <h3 class="sr-only">Categories</h3>
                    <div>
                        <ul role="list" class="space-y-4 border-gray-200 pb-6 text-sm font-medium text-gray-900">
                            <li>
                                <a href="#">Account</a>
                            </li>
                            <li>
                                <a href="#">Address</a>
                            </li>
                            <li>
                                <a href="#">Voucher</a>
                            </li>
                            <li>
                                <a href="#">Order History</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="border-t border-gray-200 px-6 py-4">
                        <button type="submit" class="button bg-gray-900 py-2 text-white hover:bg-gray-700 transition duration-200 rounded-md shadow-md">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-4 mt-14">
        <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
            <h1 class="text-4xl pb-3 font-bold tracking-tight text-gray-900">Account Settings</h1>
            <div class="flex items-center pt-4">
                <button id="filter-button" class="ml-4 lg:hidden text-gray-700 hover:text-gray-900 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                    </svg>
                </button>
            </div>
        </div>
    
        <section aria-labelledby="account-details-heading" class="pb-24 pt-6">
            <div class="grid grid-cols-1 gap-y-10 lg:grid-cols-4">
                <!-- Filters for larger screens -->
                <form class="hidden lg:block">
                    <div>
                        <ul role="list" class="space-y-4 border-gray-200 pb-6 text-sm font-medium text-gray-900">
                            <li>
                                <a href="{{ url('/account/' . $khachhang->MaKH) }}">Account</a>
                            </li>
                            <li>
                                <a href="{{ url('/addresses/' . $khachhang->MaKH) }}">Address</a>
                            </li>
                            <li>
                                <a href={{ url('/voucher/{MaKH}') }}">Voucher</a>
                            </li>
                            <li>
                                <a href="{{ url('/order-history/{MaKH}') }}">Order History</a>
                            </li>
                        </ul>
                    </div>
                </form>
            <!-- Form tạo địa chỉ -->
            <div class="col-span-3 bg-gray-50 border-l">
                <form method="POST" action="{{ route('addresses.create') }}">
                    @csrf
                    <input type="hidden" id="MaKH" name="MaKH" value="{{ $MaKH }}">

                    <div class="col-span-1 md:col-span-4 mb-5">
                        <label for="diachi" class="mb-2 block text-sm font-medium text-gray-900">Địa chỉ</label>
                        <input 
                            type="text" 
                            id="diachi" 
                            name="Duong"  
                            placeholder="Nhập địa chỉ" 
                            required 
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                        />
                        <div id="diachiError" class="text-red-600 text-sm mt-1">
                            {{ $errors->first('Duong') }} 
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 items-center justify-center">
                        <div class="col-span-1">
                            <label for="tinh" class="mb-2 block text-sm font-medium text-gray-900">Tỉnh</label>
                            <select 
                                id="tinh" 
                                name="Tinh" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn tỉnh</option>
                                <!-- populate options with data from your database or API -->
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label for="quan" class="mb-2 block text-sm font-medium text-gray-900">Quận/Huyện</label>
                            <select 
                                id="quan" 
                                name="Huyen"  
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn quận/huyện</option>
                            </select>
                        </div>

                        <div class="col-span-1">
                            <label for="phuong" class="mb-2 block text-sm font-medium text-gray-900">Phường/Xã</label>
                            <select 
                                id="phuong" 
                                name="Phuong" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn xã/phường</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="mt-4 bg-blue-500 text-white rounded-lg px-4 py-2">Thêm địa chỉ</button>
                </form>

                <!-- Hiển thị các địa chỉ đã thêm -->
                @if($addresses->isNotEmpty())
                    <h2 class="mt-5">Danh sách địa chỉ</h2>
                    <ul>
                        @foreach($addresses as $address)
                            <li>{{ $address->Duong }} - {{ $address->Phuong }}, {{ $address->Huyen }}, {{ $address->Tinh }}
                                <form action="{{ route('addresses.delete', $address->MaDC) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Xóa</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Chưa có địa chỉ nào được thêm.</p>
                @endif
            </div>
       
    </main>
</div>

<script>
    document.querySelector('#filter-button').addEventListener('click', function() {
        document.querySelector('#canvas-filter').classList.toggle('hidden');
    });

    document.querySelector('#close-filter').addEventListener('click', function() {
        document.querySelector('#canvas-filter').classList.add('hidden');
    });
</script>
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
