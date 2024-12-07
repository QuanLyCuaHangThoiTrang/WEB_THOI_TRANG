@php
    $commonData = [
        'en' => [
            'voucher' => 'Voucher',
            'no_voucher' => 'You don\'t have any vouchers.',
            'sort_default' => 'Sort by',
            'sort_percent_asc' => 'Discount: Low to High',
            'sort_percent_desc' => 'Discount: High to Low',
            'sort_date_asc' => 'Expiration: Soonest to Latest',
            'sort_date_desc' => 'Expiration: Latest to Soonest',
            'accumulated_points' => 'Accumulated Points',
            'discount_code' => 'Discount Code',
            'expired_date' => 'Expired Date',
        ],
        'vi' => [
            'voucher' => 'Phiếu giảm giá',
            'no_voucher' => 'Bạn chưa có voucher nào.',
            'sort_default' => 'Sắp xếp theo',
            'sort_percent_asc' => 'Giảm giá từ thấp đến cao',
            'sort_percent_desc' => 'Giảm giá từ cao đến thấp',
            'sort_date_asc' => 'Ngày hết hạn từ sớm đến muộn',
            'sort_date_desc' => 'Ngày hết hạn từ muộn đến sớm',
            'accumulated_points' => 'Điểm tích lũy',
            'discount_code' => 'Mã giảm giá',
            'expired_date' => 'Ngày hết hạn',
        ],
    ];

    // Lấy ngôn ngữ hiện tại từ URL
    $locale = request()->segment(1, 'vi'); // Mặc định là 'vi' nếu không có ngôn ngữ trong URL

    // Lấy dữ liệu theo ngôn ngữ hiện tại
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fallback về 'vi' nếu không tìm thấy
@endphp

@extends('layouts.app')
@section('content')
    <div class="bg-white">
        @include('account.components.notification')
        <main class="mx-auto px-24 mt-14">
            @if (session('success'))
                <div
                    class="notification absolute z-30 top-24 right-10 bg-green-400 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="notification absolute z-30 top-24 right-10 bg-red-500 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
                <div>
                    <h1 class="text-4xl pb-3 font-bold tracking-tight text-gray-900">{{ $selectedData['voucher'] }}</h1>
                </div>

            </div>

            <section aria-labelledby="account-details-heading" class="pb-24 pt-6">
                <div class="grid grid-cols-1 gap-y-10 lg:grid-cols-4">
                    <!-- Filters for larger screens -->

                    @include('account.components.filters')

                    <!-- Vouchers Section -->
                    <div class="col-span-3 bg-white border-l rounded-lg shadow-md">
                        <div class="bg-blue-950 w-full py-2 relative rounded-t-lg"></div>
                        <div class="flex-1 pb-2 w-full max-xl:max-w-3xl max-xl:mx-auto">
                            <div class="flex flex-col px-7 gap-4 p-4">
                                <div class="border-b">
                                    <div class="flex items-baseline justify-between border-b border-gray-200 py-5">
                                        <div>
                                            <p class="text-black font-medium text-3xl">
                                                {{ $selectedData['accumulated_points'] }}:
                                                {{ $khachhang->DiemTichLuy }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="gap-4 sm:flex sm:items-center sm:justify-between sm:space-y-0 flex flex-col sm:flex-row py-3 sm:space-x-4">
                                        <h3 class="text-3xl font-medium text-gray-900 mb-4 sm:mb-0"
                                            id="account-details-heading">
                                            {{ $selectedData['voucher'] }}
                                        </h3>
                                        <div
                                            class="mt-6 sm:mt-0 sm:flex sm:items-center sm:justify-end sm:space-x-4 space-y-4 sm:space-y-0 w-full sm:w-auto">
                                            <form id="search-form" method="GET"
                                                action="{{ url("/{$locale}/vouchers/" . $khachhang->MaKH) }}"
                                                class="w-full sm:w-auto flex flex-col sm:flex-row justify-between items-center">
                                                <div class="flex space-x-2 w-full">
                                                    <div class="flex-shrink-0 w-full sm:w-auto">
                                                        <select name="sort" id="sort-select"
                                                            class="border-2 border-gray-300 py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 focus:outline-none rounded-md mt-2 sm:mt-0 w-full sm:w-auto">
                                                            <option value="default">{{ $selectedData['sort_default'] }}
                                                            </option>
                                                            <option value="percent_asc"
                                                                {{ request()->get('sort') == 'percent_asc' ? 'selected' : '' }}>
                                                                {{ $selectedData['sort_percent_asc'] }}</option>
                                                            <option value="percent_desc"
                                                                {{ request()->get('sort') == 'percent_desc' ? 'selected' : '' }}>
                                                                {{ $selectedData['sort_percent_desc'] }}</option>
                                                            <option value="date_asc"
                                                                {{ request()->get('sort') == 'date_asc' ? 'selected' : '' }}>
                                                                {{ $selectedData['sort_date_asc'] }}</option>
                                                            <option value="date_desc"
                                                                {{ request()->get('sort') == 'date_desc' ? 'selected' : '' }}>
                                                                {{ $selectedData['sort_date_desc'] }}</option>
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
                                            @if ($vouchers->isEmpty())
                                                <img src="{{ asset('svg/empty.svg') }}" alt="No vouchers"
                                                    class="mx-auto h-80 w-80">
                                                <p class="text-gray-600 text-center">{{ $selectedData['no_voucher'] }}</p>
                                            @else
                                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                                    @foreach ($vouchers as $voucher)
                                                        <div
                                                            class="bg-gradient-to-r from-blue-800 to-blue-900 hover:from-blue-900 hover:to-blue-950 transition-all duration-400 flex flex-col text-center text-white justify-center items-center rounded-lg shadow-lg p-6 transform ">
                                                            <h3
                                                                class="text-3xl font-semibold uppercase mb-3 text-white border-b-2 pb-2 border-blue-300">
                                                                {{ $voucher->MaVoucher }}
                                                            </h3>
                                                            <p class="text-xl font-medium text-blue-200 mb-4">
                                                                {{ $selectedData['discount_code'] }}
                                                                {{ $voucher->PhanTramGiamGia }}%
                                                            </p>
                                                            <p class="text-md text-blue-100">
                                                                {{ $selectedData['expired_date'] }}: <span
                                                                    class="text-lg font-bold text-yellow-400">{{ date('d-m-Y', strtotime($voucher->NgayKT)) }}</span>
                                                            </p>
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
