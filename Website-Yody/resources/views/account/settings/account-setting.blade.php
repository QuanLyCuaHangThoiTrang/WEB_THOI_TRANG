@php
    // Define translations for both languages
    $commonData = [
        'en' => [
            'account_settings' => 'Account Settings',
            'account_details' => 'Account Details',
            'save_button' => 'Save',
            'change_password' => 'Change Password',
            'google_account_warning' => 'Google accounts cannot change password.',
            'customer_name' => 'Customer Name',
            'username' => 'Username',
            'email' => 'Email',
            'new_password' => 'New Password',
            'confirm_new_password' => 'Confirm New Password',
            'full_name_placeholder' => 'Enter full name',
            'username_placeholder' => 'Enter username',
            'email_placeholder' => 'Enter email',
            'new_password_placeholder' => 'Enter new password',
            'confirm_new_password_placeholder' => 'Confirm new password',
        ],
        'vi' => [
            'account_settings' => 'Cài đặt tài khoản',
            'account_details' => 'Chi tiết tài khoản',
            'save_button' => 'Lưu',
            'change_password' => 'Đổi mật khẩu',
            'google_account_warning' => 'Tài khoản Google không thể thay đổi mật khẩu.',
            'customer_name' => 'Tên khách hàng',
            'username' => 'Tài khoản',
            'email' => 'Email',
            'new_password' => 'Mật khẩu mới',
            'confirm_new_password' => 'Xác nhận mật khẩu mới',
            'full_name_placeholder' => 'Nhập tên đầy đủ',
            'username_placeholder' => 'Nhập tên đăng nhập',
            'email_placeholder' => 'Nhập email',
            'new_password_placeholder' => 'Nhập mật khẩu mới',
            'confirm_new_password_placeholder' => 'Xác nhận mật khẩu mới',
        ],
    ];

    // Get the current language code
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp
@extends('layouts.app')
@section('content')
    <div class="bg-white">
        <main class="mx-auto px-24 mt-14">
            @include('account.components.notification')
            <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
                <h1 class="text-4xl pb-3 font-bold tracking-tight text-gray-900">{{ $selectedData['account_settings'] }}</h1>
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
                    @include('account.components.filters')

                    <div class="col-span-3 bg-white border-l rounded-lg shadow-md">
                        <div class="bg-blue-950 w-full py-2 relative rounded-t-lg"></div>
                        <div class="flex-1 pb-8 w-full max-xl:max-w-3xl max-xl:mx-auto">
                            <div class="flex flex-col px-7 gap-4 md:gap-4 p-6 mb-6">
                                <div class="border-b">
                                    <h3 class="text-3xl font-semibold text-gray-900 mb-4" id="account-details-heading">
                                        {{ $selectedData['account_details'] }}</h3>
                                </div>
                                <form
                                    action="{{ route('account.updateAccount', ['locale' => app()->getLocale(), 'MaKH' => $khachhang->MaKH]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label for="full_name"
                                            class="block py-2 text-sm font-medium text-gray-700">{{ $selectedData['customer_name'] }}</label>
                                        <input id="full_name" name="full_name"
                                            value="{{ Auth::check() ? Auth::user()->HoTen : '' }}" type="text" required
                                            class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 focus:outline-none rounded-md"
                                            placeholder="{{ $selectedData['full_name_placeholder'] }}" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="taikhoan"
                                            class="block text-sm py-2 font-medium text-gray-700">{{ $selectedData['username'] }}</label>
                                        <input id="taikoan" name="taikhoan"
                                            value="{{ Auth::check() ? Auth::user()->Username : '' }}" type="text"
                                            class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 focus:outline-none rounded-md"
                                            placeholder="{{ $selectedData['username_placeholder'] }}" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="email"
                                            class="block text-sm py-2 font-medium text-gray-700">{{ $selectedData['email'] }}</label>
                                        <input id="email" name="email"
                                            value="{{ Auth::check() ? Auth::user()->Email : '' }}" readonly type="text"
                                            required
                                            class="w-full border-2 border-gray-300 border-l-[7px] bg-blue-100 py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 focus:outline-none rounded-md"
                                            placeholder="{{ $selectedData['email_placeholder'] }}" />
                                    </div>

                                    <div class="mt-4 flex justify-end">
                                        <button type="submit"
                                            class="button bg-blue-900 px-16 py-2 text-white hover:bg-blue-500 transition duration-200 rounded-md shadow-md">{{ $selectedData['save_button'] }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="bg-blue-950 w-full py-2 relative"></div>
                            <div class="flex flex-col px-7 gap-4 md:gap-4 p-6">
                                <div class="border-b">
                                    <h3 class="text-3xl font-semibold text-gray-900 mb-4" id="account-details-heading">
                                        {{ $selectedData['change_password'] }}</h3>
                                </div>
                                @if (!$isGoogleAccount)
                                    <form
                                        action="{{ route('account.updatePassword', ['locale' => app()->getLocale(), 'MaKH' => $khachhang->MaKH]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label for="new_password"
                                                class="block text-sm font-medium py-2 text-gray-700">{{ $selectedData['new_password'] }}</label>
                                            <input name="new_password" type="text"
                                                class="w-full border-2 border-gray-300 py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 border-l-[7px] focus:outline-none rounded-md"
                                                placeholder="{{ $selectedData['new_password_placeholder'] }}">
                                        </div>
                                        <div class="mb-4">
                                            <label for="new_password_confirmation"
                                                class="block text-sm py-2 font-medium text-gray-700">{{ $selectedData['confirm_new_password'] }}</label>
                                            <input name="new_password_confirmation" type="password"
                                                class="w-full border-2 border-gray-300 py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600 duration-500 border-l-[7px] focus:outline-none rounded-md"
                                                placeholder="{{ $selectedData['confirm_new_password_placeholder'] }}">
                                        </div>
                                        <div class="mt-4 flex justify-end">
                                            <button type="submit"
                                                class="button bg-blue-900 px-16 py-2 text-white hover:bg-blue-500 transition duration-200 rounded-md shadow-md">{{ $selectedData['save_button'] }}</button>
                                        </div>
                                    </form>
                                @else
                                    <div class="mt-4 text-red-600">{{ $selectedData['google_account_warning'] }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
<script src="{{ asset('js/notifications.js') }}"></script>
