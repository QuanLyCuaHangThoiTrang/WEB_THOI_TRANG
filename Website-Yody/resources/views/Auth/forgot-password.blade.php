@php
    // Define translations for both languages
    $commonData = [
        'en' => [
            'forgot_password' => 'Forgot Password?',
            'login_here' => 'Login here',
            'email' => 'Email',
            'placeholder_email' => 'Enter your email',
            'send_reset_link' => 'Send Reset Link',
        ],
        'vi' => [
            'forgot_password' => 'Quên mật khẩu?',
            'login_here' => 'Đăng nhập tại đây',
            'email' => 'Email',
            'placeholder_email' => 'Nhập email',
            'send_reset_link' => 'Gửi liên kết',
        ],
    ];
    // Get the current language code
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp
@extends('layouts.app')
@section('content')
    <div class="mt-20 bg-slate-200 py-2">
        <div class="flex flex-col items-center justify-center">
            <div
                class="grid md:grid-cols-2 items-center bg-white gap-4 max-md:gap-8 max-w-5xl max-md:max-w-lg w-full p-4 m-4 shadow-md rounded-md">
                <div class="md:max-w-md w-full px-4">
                    <form action="{{ route('password.email', ['locale' => app()->getLocale()]) }}" method="POST">
                        @csrf
                        <div class="mt-4 mb-12">
                            <h3 class="text-gray-800 text-3xl font-bold">{{ $selectedData['forgot_password'] }}</h3>
                            <p class="text-sm mt-4 text-gray-800">{{ $selectedData['login_here'] }} <a
                                    href="{{ url("/{$locale}/login") }}"
                                    class="text-yellow-600 font-semibold hover:underline ml-1">{{ $selectedData['login_here'] }}</a>
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="text-gray-800 text-xs block mb-2">{{ $selectedData['email'] }}</label>
                            <input name="email" type="email" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 py-3 outline-none"
                                placeholder="{{ $selectedData['placeholder_email'] }}" />
                            @error('email')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-yellow-500 hover:bg-yellow-600 duration-150 focus:outline-none">
                                {{ $selectedData['send_reset_link'] }}
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
