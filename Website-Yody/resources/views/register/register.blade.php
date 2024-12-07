@php
    // Define the translations for each language
    $commonData = [
        'en' => [
            'full_name' => 'Full Name',
            'placeholder_full_name' => 'Enter full name',
            'username' => 'Username',
            'placeholder_username' => 'Enter username',
            'phone_number' => 'Phone Number',
            'placeholder_phone_number' => 'Enter phone number',
            'email' => 'Email',
            'placeholder_email' => 'Enter email',
            'password' => 'Password',
            'placeholder_password' => 'Enter password',
            'password_confirmation' => 'Confirm Password',
            'placeholder_password_confirmation' => 'Confirm your password',
            'register' => 'Register',
            'already_have_account' => 'Already have an account?',
            'login_here' => 'Login here',
        ],
        'vi' => [
            'full_name' => 'Họ và tên',
            'placeholder_full_name' => 'Nhập họ và tên',
            'username' => 'Tên người dùng',
            'placeholder_username' => 'Nhập tên người dùng',
            'phone_number' => 'Số điện thoại',
            'placeholder_phone_number' => 'Nhập số điện thoại',
            'email' => 'Email',
            'placeholder_email' => 'Nhập email',
            'password' => 'Mật khẩu',
            'placeholder_password' => 'Nhập mật khẩu',
            'password_confirmation' => 'Xác nhận mật khẩu',
            'placeholder_password_confirmation' => 'Xác nhận mật khẩu',
            'register' => 'Đăng ký',
            'already_have_account' => 'Đã có tài khoản?',
            'login_here' => 'Đăng nhập tại đây',
        ],
    ];

    // Get the language code from the URL
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp
@extends('layouts.app')

@section('content')
    <div class="mt-20 bg-slate-200 py-2">
        <div class="flex flex-col items-center justify-center">
            <div
                class="grid md:grid-cols-2 items-center bg-white gap-4 max-md:gap-8 max-w-5xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
                <div class="md:max-w-md w-full px-4">
                    <form action="{{ route('register', ['locale' => app()->getLocale()]) }}" method="POST">
                        @csrf
                        <div class="mb-12">
                            <h3 class="text-gray-800 text-3xl font-extrabold">{{ $selectedData['register'] }}</h3>
                            <p class="text-sm mt-4 text-gray-800">{{ $selectedData['already_have_account'] }} <a
                                    href="{{ url("/{$locale}/login") }}"
                                    class="text-yellow-600 font-semibold hover:underline ml-1 whitespace-nowrap">{{ $selectedData['login_here'] }}</a>
                            </p>
                        </div>

                        <!-- Full Name -->
                        <div class="mb-4">
                            <label class="text-gray-800 text-xs block mb-2">{{ $selectedData['full_name'] }}</label>
                            <input name="full_name" type="text" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none"
                                placeholder="{{ $selectedData['placeholder_full_name'] }}" />
                            @error('full_name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="mb-4">
                            <label class="text-gray-800 text-xs block mb-2">{{ $selectedData['username'] }}</label>
                            <input name="username" type="text" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none"
                                placeholder="{{ $selectedData['placeholder_username'] }}" />
                            @error('username')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-4">
                            <label class="text-gray-800 text-xs block mb-2">{{ $selectedData['phone_number'] }}</label>
                            <input name="phone_number" type="text" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none"
                                placeholder="{{ $selectedData['placeholder_phone_number'] }}" />
                            @error('phone_number')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="text-gray-800 text-xs block mb-2">{{ $selectedData['email'] }}</label>
                            <input name="email" type="text" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none"
                                placeholder="{{ $selectedData['placeholder_email'] }}" />
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <label class="text-gray-800 text-xs block mb-2">{{ $selectedData['password'] }}</label>
                            <input name="password" type="password" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none"
                                placeholder="{{ $selectedData['placeholder_password'] }}" />
                            @error('password')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <label
                                class="text-gray-800 text-xs block mb-2">{{ $selectedData['password_confirmation'] }}</label>
                            <input name="password_confirmation" type="password" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none"
                                placeholder="{{ $selectedData['placeholder_password_confirmation'] }}" />
                            @error('password_confirmation')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-yellow-500 hover:bg-yellow-600 duration-150 focus:outline-none">
                                {{ $selectedData['register'] }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="md:h-full bg-[#000842] rounded-xl lg:p-12 p-8">
                    <img src="https://m.yodycdn.com/fit-in/filters:format(webp)/products/ao-khoac-ni-the-thao-nu-yody-swn6010-tra-03.jpg"
                        class="w-full h-full object-contain" alt="login-image" />
                </div>
            </div>
        </div>
    </div>
@endsection
