@extends('layouts.app')

@section('content')
<div class="bg-white">
    @include('account.components.notification')

    <main class="mx-auto max-w-7xl px-4 mt-14">
        @if(session('success'))
        <div class="notification absolute z-30 top-24 right-10 bg-green-400 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="notification absolute z-30 top-24 right-10 bg-red-500 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
            <div>
                <h1 class="text-4xl pb-3 font-bold tracking-tight text-gray-900">Account Settings</h1>
            </div>
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
                                <a href="{{ url('/account/' . $khachhang->MaKH) }}">Tài khoản</a>
                            </li>
                            <li>
                                <a href="{{ url('/addresses/' . $khachhang->MaKH) }}">Địa chỉ</a>
                            </li>
                            <li>
                                <a href="{{ url('/vouchers/' . $khachhang->MaKH) }}">Phiếu giảm giá</a>
                            </li>
                            <li>
                                <a href="{{ url('/order-history/' . $khachhang->MaKH) }}">Lịch sử đơn hàng</a>
                            </li>
                        </ul>
                    </div>
                </form>

                <!-- Vouchers Section -->
                <div class="col-span-3 bg-white border-l rounded-lg shadow-md">
                    <div class="bg-blue-950 w-full py-2 relative rounded-t-lg"></div>
                    <div class="flex-1 pb-2 w-full max-xl:max-w-3xl max-xl:mx-auto">
                        <div class="flex flex-col px-7 gap-4 p-4">
                            <div class="border-b">
                                <h3 class="text-3xl font-semibold text-gray-900 mb-4" id="account-details-heading">Vouchers</h3>
                            </div>
                            <div>
                                <div class="container mx-auto">
                                    
                                    <form id="search-form" method="GET" action="{{ url('/vouchers/' . $khachhang->MaKH) }}" class="flex flex-col sm:flex-row justify-between items-center mb-4">
                                        <div class="flex space-x-2 w-full mb-5">
                                            <div class=" flex-grow">
                                                <label for="search" class="block py-2 text-sm font-medium text-gray-700">Tìm kiếm</label>
                                                    <input type="text" name="search" id="search-input" placeholder="Tìm kiếm" class="border-2 border-gray-300 py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 border-l-[7px] focus:outline-none rounded-lg w-52" value="{{ request()->get('search') }}">
                                                   
                                            </div>
                                            <div class=" flex-shrink-0">
                                                <label for="sort" class="block py-2 text-sm font-medium text-gray-700">Sắp xếp</label>
                                                <select name="sort" id="sort-select" class="border-2 border-gray-300 py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 border-l-[7px] focus:outline-none rounded-md mt-2 sm:mt-0">
                                                    <option value="default">Sắp xếp theo</option>
                                                    <option value="percent_asc" {{ request()->get('sort') == 'percent_asc' ? 'selected' : '' }}>Giảm giá từ thấp đến cao</option>
                                                    <option value="percent_desc" {{ request()->get('sort') == 'percent_desc' ? 'selected' : '' }}>Giảm giá từ cao đến thấp</option>
                                                    <option value="date_asc" {{ request()->get('sort') == 'date_asc' ? 'selected' : '' }}>Ngày hết hạn từ sớm đến muộn</option>
                                                    <option value="date_desc" {{ request()->get('sort') == 'date_desc' ? 'selected' : '' }}>Ngày hết hạn từ muộn đến sớm</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </form>
                                    <div class="border-t pt-5">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                            @foreach($vouchers as $voucher)
                                            <div class="bg-gradient-to-br from-blue-950 to-blue-900 flex flex-col text-white text-center justify-center items-center px-6 rounded-lg relative w-full max-w-xs border-gray-300 shadow-lg">
                                                <h3 class="text-xl font-semibold mb-4">{{ $voucher->TenVoucher }}<br><span class="font-light">dành cho hội viên</span></h3>
                                                <div class="flex justify-end space-x-2 mb-2">
                                                    <span id="cpnCode" class="bg-white text-blue-950 font-bold px-4 py-1 rounded-l">{{ $voucher->MaVoucher }}</span>
                                                </div>
                                                <p class="text-sm">Valid Till: {{ $voucher->NgayKT }}</p>
                                                <div class="w-12 h-12 bg-white rounded-full absolute top-1/2 transform -translate-y-1/2 left-0 -ml-6"></div>
                                                <div class="w-12 h-12 bg-white rounded-full absolute top-1/2 transform -translate-y-1/2 right-0 -mr-6"></div>
                                            </div>
                                            @endforeach

                                            @if($vouchers->isEmpty())
                                            <p class="text-gray-600">Bạn không có voucher nào.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<script>
    // Tự động gửi form khi người dùng chọn một tùy chọn trong select

    // Tự động gửi form khi người dùng nhập vào ô tìm kiếm
    document.getElementById('search-input').addEventListener('change', function() {
    console.log('Submitting form with sort:', this.value); // Log giá trị được chọn
    document.getElementById('search-form').submit();
});


// Tự động gửi form khi người dùng chọn một tùy chọn trong select
document.getElementById('sort-select').addEventListener('change', function() {
    console.log('Submitting form with sort:', this.value); // Log giá trị được chọn
    document.getElementById('search-form').submit();
});

</script>
@endsection

<script src="{{ asset('js/notifications.js') }}"></script>

