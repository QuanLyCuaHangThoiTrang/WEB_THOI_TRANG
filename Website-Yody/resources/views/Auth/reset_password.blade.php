@php
    // Define translations for both languages
    $commonData = [
        'en' => [
            'reset_password' => 'Reset Password',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm Password',
            'conpletion' => 'Confirmation',
        ],
        'vi' => [
            'reset_password' => 'Đặt lại mật khẩu',
            'new_password' => 'Mật khẩu mới',
            'confirm_password' => 'Xác nhận mật khẩu',
            'reset_password_success' => 'Mật khẩu đã được đặt lại thành công',
            'completion' => 'Hoàn tất',
        ],
    ];
    // Get the current language code
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp
@extends('layouts.app')
@section('content')
    <div class=" min-h-screen bg-slate-200 py-2 mt-20">
        @include('account.components.notification')
        <div class="flex flex-col mx-auto items-center justify-center">
            <div
                class="grid md:grid-cols-2 items-center bg-white gap-4 max-md:gap-8 max-w-5xl max-md:max-w-lg w-full p-4 m-4 shadow-md rounded-md">
                <div class="md:max-w-md w-full px-4">
                    <form action="{{ route('password.reset', ['locale' => app()->getLocale()]) }}" method="POST">
                        @csrf
                        <div class="mb-12">
                            <h3 class="text-gray-800 text-3xl font-bold">{{ $selectedData['reset_password'] }}</h3>
                        </div>

                        @if ($errors->any())
                            <div class="mb-4">
                                <div class="text-red-600 text-sm">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="text-gray-800 text-xs block mb-2">Email</label>
                            <input name="email" type="email" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none transition duration-200"
                                placeholder="Nhập email" value="{{ $email }}">
                            <input name="email" type="hidden" value="{{ $email }}">
                        </div>

                        <div class="mb-4">
                            <label class="text-gray-800 text-xs block mb-2">{{ $selectedData['new_password'] }}</label>
                            <input name="password" type="password" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none transition duration-200"
                                placeholder="Nhập mật khẩu mới" />
                        </div>

                        <div class="mb-4">
                            <label class="text-gray-800 text-xs block mb-2">{{ $selectedData['confirm_password'] }}</label>
                            <input name="password_confirmation" type="password" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none transition duration-200"
                                placeholder="Xác nhận mật khẩu mới" />
                        </div>


                        <div class="mt-12">
                            <button type="submit"
                                class="w-full shadow-lg py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-yellow-500 duration-150 focus:outline-none transition-transform transform hover:scale-105">
                                {{ $selectedData['completion'] }}
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
