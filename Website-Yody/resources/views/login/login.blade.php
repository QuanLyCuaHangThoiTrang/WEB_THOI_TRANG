@extends('layouts.app')

@section('content')
<div class="font-old-standard bg-slate-200 py-2 mt-20">
    <div class="flex flex-col items-center justify-center">
        <div class="grid md:grid-cols-2 items-center bg-white gap-4 max-md:gap-8 max-w-5xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
            <div class="md:max-w-md w-full px-4">
                <form action="{{ route('login.postLogin') }}" method="POST">
                    @csrf
                    <div class="mb-12">
                        <h3 class="text-gray-800 text-3xl font-extrabold">Sign in</h3>
                        <p class="text-sm mt-4 text-gray-800">Don't have an account <a href="{{ url('/register') }}" class="text-yellow-600 font-semibold hover:underline ml-1 whitespace-nowrap">Register here</a></p>
                    </div>

                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Username</label>
                        <div class="relative flex items-center">
                            <input name="taikhoan" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter username" value="{{ old('taikhoan') }}" autocomplete="username" />
                        </div>
                    </div>

                    <div class="mt-8">
                        <label class="text-gray-800 text-xs block mb-2">Password</label>
                        <div class="relative flex items-center">
                            <input id="password" name="matkhau" type="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter password" autocomplete="current-password" />
                            <button type="button" id="toggle-password" class="absolute right-0 top-0 mt-3 mr-2" onclick="togglePasswordVisibility()">
                                <span id="password-text" class="text-gray-500 text-sm">Show</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4 mt-6">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                            <label for="remember-me" class="ml-3 block text-sm text-gray-800">
                                Remember me
                            </label>
                        </div>
                        <div>
                            <a   href="{{ url('/forgot-password') }}"  class="text-blue-600 font-semibold text-sm hover:underline">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                    @if ($errors->any())
                    <div class="bg-red-100 border mt-7 border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Thử lại!</strong>
                        @foreach ($errors->all() as $error)
                        <span class="block sm:inline">{{ $error }}</span>
                        @endforeach
                    </div>
                    @endif
                    <div class="mt-12">
                        <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-yellow-500 hover:bg-yellow-600 duration-150 focus:outline-none">
                            Sign in
                        </button>
                    </div>

                    <div class="space-x-6 flex justify-center mt-6">
                        <button type="button" class="border-none outline-none">
                            <x-icons.icon name="google"/>
                        </button>
                    </div>
                </form>
            </div>

            <div class="md:h-full bg-[#000842] rounded-xl lg:p-12 p-8">
                <img src="https://m.yodycdn.com/fit-in/filters:format(webp)/products/ao-thun-tre-em-TSK7247-DEN%20(1).JPG" class="w-full h-full object-contain" alt="login-image" />
            </div>
        </div>
    </div>
</div>

<script>
// function setCookie(name, value, days) {
//     const expires = new Date(Date.now() + days * 864e5).toUTCString();
//     document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/';
// }

// function getCookie(name) {
//     return document.cookie.split('; ').reduce((r, v) => {
//         const parts = v.split('=');
//         return parts[0] === name ? decodeURIComponent(parts[1]) : r;
//     }, '');
// }

// document.addEventListener('DOMContentLoaded', function() {
//     const usernameInput = document.querySelector('input[name="taikhoan"]');
//     const passwordInput = document.querySelector('input[name="matkhau"]');
//     const rememberMeCheckbox = document.getElementById('remember-me');

//     // Kiểm tra xem có thông tin đã lưu không
//     usernameInput.value = getCookie('username') || '';
//     passwordInput.value = getCookie('password') || '';
//     rememberMeCheckbox.checked = !!getCookie('rememberMe');

//     // Lưu thông tin khi người dùng đăng nhập
//     document.querySelector('form').addEventListener('submit', function() {
//         if (rememberMeCheckbox.checked) {
//             setCookie('rememberMe', 'true', 7); // 7 ngày
//             setCookie('username', usernameInput.value, 7);
//             setCookie('password', passwordInput.value, 7);
//         } else {
//             setCookie('rememberMe', '', -1); // Xóa cookie
//             setCookie('username', '', -1);
//             setCookie('password', '', -1);
//         }
//     });
// });
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const passwordText = document.getElementById('password-text');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordText.innerText = 'Hide'; // Đổi chữ thành 'Hide Password'
    } else {
        passwordInput.type = 'password';
        passwordText.innerText = 'Show'; // Đổi chữ thành 'Show Password'
    }
}
</script>

@endsection
