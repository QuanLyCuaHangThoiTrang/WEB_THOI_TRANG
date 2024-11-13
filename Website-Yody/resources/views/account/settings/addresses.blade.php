@extends('layouts.app')
@section('content')
    <div class=" bg-white">
        <!-- Filter Dialog -->


        <main class="mx-auto px-24 mt-14">
            @include('account.components.notification')
            @if ($errors->any())
                <div
                    class="notification absolute z-30 top-24 right-10 bg-red-400 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif


            <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">

                <div>
                    <h1 class="text-4xl pb-3 font-bold tracking-tight text-gray-900">Địa chỉ</h1>
                </div>

                <div class="flex items-center pt-4">
                    <button id="filter-button"
                        class="ml-4 lg:hidden text-gray-700 hover:text-gray-900 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <section aria-labelledby="account-details-heading" class="pb-24 pt-6">
                <div class="grid grid-cols-1 gap-y-10 lg:grid-cols-4">
                    <!-- Filters for larger screens -->
                    @include('account.components.filters')


                    <!-- Form tạo địa chỉ -->
                    <div class="col-span-3 bg-white border-l rounded-lg shadow-md">
                        <div class="bg-blue-950 w-full py-2 relative rounded-t-lg"></div>
                        <div class="flex-1 pb-2 w-full max-xl:max-w-3xl max-xl:mx-auto">
                            <div class="flex flex-col px-7 gap-4 p-6">
                                <div class="border-b">
                                    <h3 class="text-3xl font-semibold text-gray-900 mb-4" id="account-details-heading">
                                        Địa chỉ khách hàng</h3>
                                </div>
                                <form method="POST" action="{{ route('addresses.create') }}">
                                    @csrf
                                    <input type="hidden" id="MaKH" name="MaKH" value="{{ $MaKH }}">
                                    <div class="mb-3">
                                        <label for="diachi" class="mb-2 block text-sm font-medium text-gray-900">Địa
                                            chỉ</label>
                                        <input type="text" id="diachi" name="Duong" placeholder="Nhập địa chỉ"
                                            required
                                            class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600  duration-500 focus:outline-none rounded-md" />

                                    </div>

                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 items-center justify-center">
                                        <div class="col-span-1">
                                            <label for="tinh"
                                                class="mb-2 block text-sm font-medium text-gray-900">Tỉnh</label>
                                            <select id="tinh" name="Tinh"
                                                class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 focus:outline-none rounded-md">
                                                <option value="">Chọn tỉnh</option>
                                            </select>
                                            <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                                        </div>

                                        <div class="col-span-1">
                                            <label for="quan"
                                                class="mb-2 block text-sm font-medium text-gray-900">Quận/Huyện</label>
                                            <select id="quan" name="Huyen"
                                                class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 focus:outline-none rounded-md">
                                                <option value="">Chọn quận/huyện</option>
                                            </select>
                                            <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                                        </div>

                                        <div class="col-span-1">
                                            <label for="phuong"
                                                class="mb-2 block text-sm font-medium text-gray-900">Phường/Xã</label>
                                            <select id="phuong" name="Phuong"
                                                class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black  duration-500 focus:outline-none rounded-md">
                                                <option value="">Chọn xã/phường</option>
                                            </select>
                                            <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">
                                        </div>
                                    </div>

                                    <div class="my-4 flex justify-end">
                                        <button type="submit"
                                            class="button bg-blue-900 px-16 py-2 text-white hover:bg-blue-500 focus:border-black transition duration-200 focus:outline-none  rounded-md shadow-md">Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        @if ($addresses->isNotEmpty())
                            <div class="col-span-3 bg-gray-50 border-l">
                                <div class="bg-blue-950 w-full py-2 relative rounded-t-lg"></div>
                                <div class="flex-1 w-full max-xl:max-w-3xl max-xl:mx-auto">
                                    <div class="flex flex-col bg-gray-50 px-7 gap-4 md:gap-4 p-6">
                                        <div class="border-b">
                                            <h3 class="text-3xl font-semibold text-gray-900 mb-4"
                                                id="account-details-heading">Danh sách địa chỉ</h3>
                                        </div>
                                        @foreach ($addresses as $index => $address)
                                            <!-- Sử dụng $index để đánh số thứ tự -->
                                            <form action="{{ route('addresses.delete', $address->MaDC) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" id="MaKH" name="MaKH"
                                                    value="{{ $MaKH }}">

                                                <div class="col-span-1 border-b md:col-span-4 mb-5">
                                                    <label for="diachi"
                                                        class="mb-2 block text-sm font-medium text-gray-900">Địa chỉ
                                                        {{ $index + 1 }}</label> <!-- Hiển thị số thứ tự -->
                                                    <div
                                                        class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black duration-500 focus:outline-none rounded-md">

                                                        {{ $address->Duong }}, {{ $address->Phuong }},
                                                        {{ $address->Huyen }}, {{ $address->Tinh }}
                                                    </div>
                                                    <div class="my-4 flex justify-end">
                                                        <button type="submit"
                                                            class="button bg-red-800 px-10 py-2 text-white hover:bg-red-700 transition duration-200 rounded-md shadow-md">Xóa</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="mb-5 px-7 font-medium text-blue-900">Chưa có địa chỉ nào được thêm.</p>
                        @endif

                    </div>

                </div>

        </main>
    </div>
@endsection
<script src="{{ asset('js/notifications.js') }}"></script>
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
                    $("#hidden_tinh").val(tenTinh); // Lưu tên tỉnh vào trường ẩn

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
            $("#hidden_quan").val(tenQuan); // Lưu tên quận vào trường ẩn

            $.getJSON('https://esgoo.net/api-tinhthanh/3/' + idquan + '.htm', function(data_phuong) {
                if (data_phuong.error === 0) {
                    $("#phuong").html('<option value="0">Phường Xã</option>');
                    $.each(data_phuong.data, function(key_phuong, val_phuong) {
                        $("#phuong").append('<option value="' + val_phuong.id + '">' +
                            val_phuong.full_name + '</option>');
                    });
                }
            });
        });

        // Lấy phường xã khi chọn phường xã
        $("#phuong").change(function(e) {
            var tenPhuong = $("#phuong option:selected").text(); // Lấy tên phường xã được chọn
            $("#hidden_phuong").val(tenPhuong); // Lưu tên phường vào trường ẩn
        });
    });
</script>
