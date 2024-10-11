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
                                <a href="{{ url('/order/' . $khachhang->MaKH) }}">Lịch sử đơn hàng</a>
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
                                <div class="flex items-baseline justify-between border-b border-gray-200 py-5">
                                    <div>
                                        <p class="text-black font-semibold text-3xl">Điểm tích lũy: {{ $khachhang->DiemTichLuy }}</p>
                                    </div>
                                </div>
                                <div class="gap-4 sm:flex sm:items-center sm:justify-between">
                                    <h3 class="text-3xl font-semibold text-gray-900 mb-4" id="account-details-heading">Vouchers</h3>
                                    <div class="mt-6 gap-4 space-y-4 sm:mt-0 sm:flex sm:items-center sm:justify-end sm:space-y-0">
                                        <form id="search-form" method="GET" action="{{ url('/vouchers/' . $khachhang->MaKH) }}" class="flex flex-col sm:flex-row justify-between items-center mb-4">
                                            <div class="flex space-x-2">
                                                <div class="flex-shrink-0 pt-3">
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
                                    </div>
                                  </div>
                            </div>
                            <div>
                                <div class="container mx-auto">
                                    <div class="pt-5">
                                        @if($vouchers->isEmpty())
                                            <img src="{{ asset('svg/empty.svg') }}" alt="No vouchers" class="mx-auto h-80 w-80">
                                            <p class="text-gray-600 text-center">Bạn chưa có voucher nào.</p>
                                        @else
                                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                                @foreach($vouchers as $voucher)
                                                    <div class="bg-gradient-to-br from-blue-950 to-blue-900 flex flex-col text-center text-white justify-center items-center rounded-lg shadow-md p-4">
                                                        <h3 class="text-lg font-bold">{{ $voucher->TenVoucher }}</h3>
                                                        <p class="text-md">{{ $voucher->PhanTramGiamGia }}% Giảm giá</p>
                                                        <p class="text-md">Hết hạn: {{ date('d-m-Y', strtotime($voucher->NgayKT)) }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <!-- Pagination -->
                            <div class="flex justify-center">
                                {{ $vouchers->links() }}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<script src="{{ asset('js/notifications.js') }}"></script>
<script>
    document.getElementById('sort-select').addEventListener('change', function() {
        this.form.submit(); // Gửi form khi thay đổi lựa chọn
    });
</script>
@endsection



