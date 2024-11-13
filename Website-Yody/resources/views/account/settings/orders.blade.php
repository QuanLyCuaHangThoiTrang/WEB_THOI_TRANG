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
                    <h1 class="text-4xl pb-3 font-bold tracking-tight text-gray-900">Đơn hàng</h1>
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


                    <!-- Orders Section -->
                    <div class="col-span-3 bg-white border-l rounded-lg shadow-md">
                        <div class="bg-blue-950 w-full py-2 relative rounded-t-lg"></div>
                        <div class="flex-1 pb-2 w-full max-xl:max-w-3xl max-xl:mx-auto">
                            <div class="flex flex-col px-7 gap-4 p-4">
                                <div class="border-b">
                                    <div class="gap-4 sm:flex sm:items-center sm:justify-between">
                                        <h3 class="text-3xl font-semibold text-gray-900 mb-4" id="account-details-heading">
                                            Đơn hàng</h3>

                                        <!-- Button to go back to orders list -->


                                        <div
                                            class="mt-6 gap-4 space-y-4 sm:mt-0 sm:flex sm:items-center sm:justify-end sm:space-y-0">
                                            <form method="GET" action="{{ url('/order/' . $khachhang->MaKH) }}"
                                                class="flex flex-col sm:flex-row justify-between items-center mb-4">
                                                <!-- Tìm kiếm và Sắp xếp -->
                                                <div
                                                    class="flex flex-col sm:flex-row justify-between items-center lg:space-x-10 gap-4 sm:gap-0">
                                                    <div class="flex-grow">
                                                        <!-- Tìm kiếm -->
                                                        <label for="search"
                                                            class="block text-sm font-medium text-gray-700">Tìm kiếm</label>
                                                        <input type="text" name="search" id="search"
                                                            placeholder="Tìm kiếm"
                                                            class="border-2 border-gray-300 py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 rounded-lg w-full sm:w-52">
                                                    </div>

                                                    <div class="flex-shrink-0 w-full sm:w-auto">
                                                        <!-- Sắp xếp -->
                                                        <label for="sort"
                                                            class="block text-sm font-medium text-gray-700">Sắp xếp
                                                            theo</label>
                                                        <select name="sort" id="sort"
                                                            class="border-2 border-gray-300 py-2 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 rounded-md w-full sm:w-auto">
                                                            <option value="default">Sắp xếp theo</option>
                                                            <option value="tat_ca">Tất cả</option>
                                                            <option value="chua_xac_nhan">Chưa xác nhận</option>
                                                            <option value="da_xac_nhan">Đã xác nhận</option>
                                                            <option value="chua_giao">Chưa giao</option>
                                                            <option value="giao_thanh_cong">Giao thành công</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </form>



                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="container mx-auto">
                                        @if ($orders->isEmpty())
                                            <div class="flex flex-col items-center justify-center">
                                                <img src="{{ asset('svg/empty.svg') }}" alt="No orders"
                                                    class="mx-auto size-80">
                                                <div class="mt-6">
                                                    <a href="{{ url('/order/' . $khachhang->MaKH) }}"
                                                        class="inline-flex items-center justify-center rounded-md bg-gray-700 px-4 py-2 text-white text-sm font-medium hover:bg-gray-800">
                                                        Quay lại tất cả đơn hàng
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="pt-5 space-y-6 ">
                                                @foreach ($orders as $order)
                                                    <div class="flex border-b flex-wrap items-center gap-y-4 py-6">
                                                        <dl class="w-full sm:w-1/4 lg:w-auto lg:flex-1">
                                                            <dt class="text-base font-medium text-gray-500">Mã đơn:</dt>
                                                            <dd class="mt-1.5 text-base font-medium text-gray-900">
                                                                <a href="#"
                                                                    class="hover:underline text-gray-900">{{ $order->MaDH }}</a>
                                                            </dd>
                                                        </dl>


                                                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                                            <dt class="text-base font-medium text-gray-500">Ngày:</dt>
                                                            <dd class="mt-1.5 text-base truncate font-medium text-gray-900">
                                                                {{ \Carbon\Carbon::parse($order->NgayDatHang)->format('d/m/Y') }}
                                                            </dd>
                                                        </dl>

                                                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                                                            <dt class="text-base font-medium text-gray-500">Tổng:</dt>
                                                            <dd
                                                                class="mt-1.5 whitespace-nowrap text-base font-medium text-gray-900">
                                                                {{ number_format($order->TongGiaTri, 0, ',', '.') }} VND
                                                            </dd>
                                                        </dl>

                                                        <dl class="w-1/3 sm:w-1/4 lg:w-auto lg:flex-1">
                                                            <dt
                                                                class="text-base font-medium  whitespace-nowrap text-gray-500">
                                                                Trạng thái:</dt>
                                                            <dd
                                                                class="mt-1.5 text-base whitespace-nowrap font-medium 
                                                            {{ $order->TrangThai == 'Giao thành công'
                                                                ? 'text-green-600'
                                                                : ($order->TrangThai == 'Đã hủy'
                                                                    ? 'text-red-600'
                                                                    : ($order->TrangThai == 'Chưa giao'
                                                                        ? 'text-yellow-500'
                                                                        : 'text-gray-900')) }}">
                                                                {{ $order->TrangThai }}
                                                            </dd>

                                                        </dl>

                                                        <div
                                                            class="w-full grid sm:grid-cols-2 lg:flex lg:w-80 lg:items-center lg:justify-end gap-4">
                                                            @if ($order->TrangThai == 'Chờ xác nhận')
                                                                <button type="button"
                                                                    class="w-full rounded-lg border border-red-700 px-3 py-2 duration-200 text-center text-sm font-medium text-red-700 hover:bg-red-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300 lg:w-auto whitespace-nowrap"
                                                                    onclick="event.preventDefault(); document.getElementById('cancel-form-{{ $order->MaDH }}').submit();">
                                                                    Hủy đơn
                                                                </button>

                                                                <form id="cancel-form-{{ $order->MaDH }}"
                                                                    action="{{ route('orders.cancel', $order->MaDH) }}"
                                                                    method="POST" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('orders.detail', [$khachhang->MaKH, $order->MaDH]) }}"
                                                                class=" w-full inline-flex justify-center rounded-lg border border-gray-200 bg-blue-900  py-2 text-sm font-medium text-white duration-300 hover:bg-blue-600 hover:text-primary-700">Xem
                                                                chi tiết</a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mt-6">
                                                {{ $orders->links() }}
                                            </div>
                                        @endif
                                    </div>
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
        // Tự động submit form khi thay đổi sắp xếp
        document.getElementById('sort').addEventListener('change', function() {
            this.form.submit();
        });
        document.getElementById('sort').addEventListener('change', function() {
            if (this.value === 'default') {
                window.location.href = "{{ url('/order/' . $khachhang->MaKH) }}";
            } else {
                this.form.submit();
            }
        });
    </script>
@endsection
