@extends('layouts.app')
@section('content')
<div class=" mt-20 bg-slate-200 py-2">
    <div class="flex flex-col items-center justify-center">
        <div class="font-[sans-serif] grid md:grid-cols-2 items-center bg-white gap-4 max-md:gap-8 max-w-5xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
            <div class="md:max-w-md w-full px-4">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-12">
                        <h3 class="text-gray-800 text-3xl font-extrabold">Tạo tài khoản</h3>
                        <p class="text-sm mt-4 text-gray-800">Đã có tài khoản? <a href="{{ url('/login') }}" class="text-yellow-600 font-semibold hover:underline ml-1 whitespace-nowrap">Đăng nhập tại đây</a></p>
                    </div>

                    <!-- Họ và tên -->
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Họ và tên</label>
                        <div class="relative flex items-center">
                            <input name="full_name" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Nhập họ và tên" />
                        </div>
                        @error('full_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tên người dùng -->
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Tên người dùng</label>
                        <div class="relative flex items-center">
                            <input name="username" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Nhập tên người dùng" />
                        </div>
                        @error('username')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Số điện thoại -->
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Số điện thoại</label>
                        <div class="relative flex items-center">
                            <input name="phone_number" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Nhập số điện thoại" />
                        </div>
                        @error('phone_number')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Email</label>
                        <div class="relative flex items-center">
                            <input name="email" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Nhập email" />
                        </div>
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mật khẩu -->
                    <div class="mt-4">
                        <label class="text-gray-800 text-xs block mb-2">Mật khẩu</label>
                        <div class="relative flex items-center">
                            <input name="password" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Nhập mật khẩu" />
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Xác nhận mật khẩu -->
                    <div class="mt-4">
                        <label class="text-gray-800 text-xs block mb-2">Xác nhận mật khẩu</label>
                        <div class="relative flex items-center">
                            <input name="password_confirmation" type="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Xác nhận mật khẩu" />
                        </div>
                        @error('password_confirmation')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-yellow-500 hover:bg-yellow-600 duration-150 focus:outline-none">
                            Đăng ký
                        </button>
                    </div>
                </form>
            </div>

            <div class="md:h-full bg-[#000842] rounded-xl lg:p-12 p-8">
                <img src="https://m.yodycdn.com/fit-in/filters:format(webp)/products/ao-khoac-ni-the-thao-nu-yody-swn6010-tra-03.jpg" class="w-full h-full object-contain" alt="login-image" />
            </div>
        </div>
    </div>
</div>
@endsection
