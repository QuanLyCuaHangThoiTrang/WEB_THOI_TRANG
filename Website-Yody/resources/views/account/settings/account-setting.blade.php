<div id="canvas-filter" class="fixed inset-0 z-50 lg:hidden hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>
    <div class="fixed inset-0 z-50 flex">
        <div class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
            <div class="flex items-center justify-between px-4">
                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                <button class="focus:outline-none" id="close-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form class="mt-4 border-t border-gray-200">
                <h3 class="sr-only">Categories</h3>
                @include('account.components.sidebar') <!-- Include sidebar -->
                <div class="border-t border-gray-200 px-4 py-6">
                    <button type="submit" class="w-full bg-gray-900 py-2 text-white hover:bg-gray-700">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

<main class="mx-auto max-w-7xl mt-14 px-4 sm:px-6 lg:px-4">
    <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
        <h1 class="text-3xl pb-3 font-bold tracking-tight text-gray-900">ACCOUNT SETTINGS</h1>
        <div class="flex items-center p-5">
            <button id="filter-button" class="ml-4 lg:hidden text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>
            </button>
        </div>
    </div>

    <section aria-labelledby="products-heading" class="pb-24 pt-6">
        <div class="grid grid-cols-1 gap-x-4 gap-y-10 lg:grid-cols-4">
            <!-- Filters -->
            <form class="hidden lg:block">
                @include('account.components.sidebar')
            </form>

            <div class="col-span-3 border-l">
                <div class="flex-1 lg:pr-8 pb-8 w-full max-xl:max-w-3xl max-xl:mx-auto">
                    <div class="flex flex-col bg-white px-7 gap-4 md:gap-4">
                        <div class="grid grid-cols-2 justify-between space-x-4">
                            <form action="{{ route('account.updateAccount', $khachhang->MaKH) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <div class="relative flex flex-col">
                                        <label for="full_name" class="mb-2 block text-sm font-medium text-gray-900"> Họ và tên </label>
                                        <input id="full_name" name="full_name" value="{{ Auth::check() ? Auth::user()->HoTen : '' }}" type="text" required class="block w-full rounded-lg border p-2.5 text-sm" placeholder="Enter full name" />

                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="relative flex flex-col">
                                        <label for="email" class="mb-2 block text-sm font-medium text-gray-900"> Email </label>
                                        <input id="email" value="{{ Auth::check() ? Auth::user()->Email : '' }}" name="email" type="text" required class="block w-full rounded-lg border p-2.5 text-sm" placeholder="Enter email" />
                                    </div>
                                </div>
                                <div class="mt-2 mb-2">
                                    <div class="relative flex flex-col justify-between">
                                        <label for="phone_number" class="mb-2 block text-sm font-medium text-gray-900"> Số điện thoại</label>
                                        <input id="phone_number" value="{{ Auth::check() ? Auth::user()->SDT : '' }}" name="phone_number" type="text" required class="block w-full rounded-lg border p-2.5 text-sm" placeholder="Enter phone number" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="w-full bg-gray-900 py-2 text-white hover:bg-gray-700">Save Changes</button>
                                </div>
                            </form>

                        @if(!$isGoogleAccount)
                        <!-- Form cập nhật mật khẩu -->
                        <form method="POST" action="{{ route('account.updatePassword', $khachhang->MaKH) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-900">Mật khẩu hiện tại</label>
                                <input name="current_password" type="password" required class="block w-full rounded-lg border p-2.5 text-sm">
                            </div>
                            <div class="mb-4">
                                <label for="new_password" class="block text-sm font-medium text-gray-900">Mật khẩu mới</label>
                                <input name="new_password" type="password" required class="block w-full rounded-lg border p-2.5 text-sm">
                            </div>
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-900">Xác nhận mật khẩu mới</label>
                                <input name="new_password_confirmation" type="password" required class="block w-full rounded-lg border p-2.5 text-sm">
                            </div>
                            <button type="submit" class="bg-blue-500 text-white rounded-lg p-2">Cập nhật mật khẩu</button>
                        </form>
                        @else
                        <!-- Thông báo cho tài khoản Google -->
                        <div class="mt-4 text-red-600">
                            Tài khoản Google không thể thay đổi mật khẩu.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
