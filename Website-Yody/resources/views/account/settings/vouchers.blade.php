@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Filter Dialog -->
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

                <!-- Form tạo địa chỉ -->
                <div class="col-span-3 bg-white border-l rounded-lg shadow-md">
                    <div class="bg-blue-950 w-full py-2 relative rounded-t-lg"></div>
                    <div class="flex-1 pb-2 w-full max-xl:max-w-3xl max-xl:mx-auto">
                        <div class="flex flex-col px-7 gap-4 p-4">
                                <h3 class="text-2xl font-semibold text-gray-900 mb-3" id="account-details-heading">Vouchers</h3>
                                <div>
                                    <div class="container mx-auto">
                                        <div class="flex flex-col-3 justify-center space-x-6">
                                            @foreach($vouchers as $voucher)
                                            <div class="bg-gradient-to-br from-blue-950 to-blue-900 flex flex-col text-white text-center px-6 rounded-lg shadow-md relative w-full max-w-xs m-2">
                                                <img src="https://i.postimg.cc/KvTqpZq9/uber.png" class="w-12 mx-auto mb-4 rounded-lg">
                                                <h3 class="text-xl font-semibold mb-4">{{ $voucher->TenVoucher }}<br><span class="font-light">dành cho hội viên</span></h3>
                                                <div class="flex  justify-end space-x-2 mb-2">
                                                    <span id="cpnCode" class=" bg-white text-blue-950 font-bold px-4 py-1 rounded-l">{{ $voucher->MaVoucher }}</span>
                                                   
                                                </div>
                                                <p class="text-sm">Valid Till: 20Dec, 2021</p>
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
        </section>
    </main>
</div>
@endsection

<script src="{{ asset('js/notifications.js') }}"></script>
