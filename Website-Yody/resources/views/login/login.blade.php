@extends('layouts.app')

@section('content')
    <div class=" bg-slate-200 py-2 mt-20">
        <div class="flex flex-col items-center justify-center">
            <div
                class="grid md:grid-cols-2 items-center bg-white gap-4 max-md:gap-8 max-w-5xl max-md:max-w-lg w-full p-4 m-4 shadow-lg rounded-lg">
                <div class="md:max-w-md w-full px-4">
                    <form action="{{ route('login.postLogin') }}" method="POST">
                        @csrf
                        <div class="mb-12">
                            <h3 class="text-gray-800 text-3xl font-bold">Đăng nhập</h3>
                            <p class="text-sm mt-4 text-gray-600">Bạn chưa có tài khoản? <a href="{{ url('/register') }}"
                                    class="text-yellow-600 font-semibold">Đăng ký tại đây</a></p>
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
                            <label class="text-gray-800 text-xs block mb-2">Tài khoản</label>
                            <input name="taikhoan" type="text" required
                                class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none transition duration-200"
                                placeholder="Nhập tài khoản" />
                        </div>

                        <div class="mt-8">
                            <label class="text-gray-800 text-xs block mb-2">Mật khẩu</label>
                            <div class="relative flex items-center">
                                <input id="password" name="matkhau" type="password" required
                                    class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none transition duration-200"
                                    placeholder="Nhập mật khẩu" autocomplete="current-password" />
                                <button type="button" id="toggle-password"
                                    class="absolute right-0 top-0 mt-3 mr-2 text-blue-500">
                                    <span id="password-text" class="text-sm">Hiện</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4 mt-6">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox"
                                    class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                                <label for="remember" class="ml-3 block text-sm text-gray-800">Nhớ tôi?</label>
                            </div>

                            <div>
                                <a href="{{ route('password.request') }}" class="text-blue-600 font-semibold text-sm">
                                    Quên mật khẩu?
                                </a>
                            </div>
                        </div>

                        <div class="mt-12">
                            <button type="submit"
                                class="w-full shadow-lg py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-yellow-500 duration-150 focus:outline-none transition-transform transform hover:scale-105">
                                Đăng nhập
                            </button>
                        </div>

                        <div class="space-x-6 flex justify-center mt-6">
                            <a href="/auth/google/redirect" class="border-none outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32px" class="inline" viewBox="0 0 512 512">
                                    <path fill="#fbbd00"
                                        d="M120 256c0-25.367 6.989-49.13 19.131-69.477v-86.308H52.823C18.568 144.703 0 198.922 0 256s18.568 111.297 52.823 155.785h86.308v-86.308C126.989 305.13 120 281.367 120 256z" />
                                    <path fill="#0f9d58"
                                        d="m256 392-60 60 60 60c57.079 0 111.297-18.568 155.785-52.823v-86.216h-86.216C305.044 385.147 281.181 392 256 392z" />
                                    <path fill="#31aa52"
                                        d="m139.131 325.477-86.308 86.308a260.085 260.085 0 0 0 22.158 25.235C123.333 485.371 187.62 512 256 512V392c-49.624 0-93.117-26.72-116.869-66.523z" />
                                    <path fill="#3c79e6"
                                        d="M512 256a258.24 258.24 0 0 0-4.192-46.377l-2.251-12.299H256v120h121.452a135.385 135.385 0 0 1-51.884 55.638l86.216 86.216a260.085 260.085 0 0 0 25.235-22.158C485.371 388.667 512 324.38 512 256z" />
                                    <path fill="#cf2d48"
                                        d="m352.167 159.833 10.606 10.606 84.853-84.852-10.606-10.606C388.668 26.629 324.381 0 256 0l-60 60 60 60c36.326 0 70.479 14.146 96.167 39.833z" />
                                    <path fill="#eb4132"
                                        d="M256 120V0C187.62 0 123.333 26.629 74.98 74.98a259.849 259.849 0 0 0-22.158 25.235l86.308 86.308C162.883 146.72 206.376 120 256 120z" />
                                </svg>
                            </a>
                        </div>
                    </form>
                </div>

                <div class="md:h-full bg-[#000842] rounded-xl lg:p-12 p-8">
                    <img src="https://m.yodycdn.com/fit-in/filters:format(webp)/products/ao-khoac-ni-the-thao-nu-yody-swn6010-tra-03.jpg"
                        class="w-full h-full object-contain rounded-lg shadow-lg" alt="login-image" />
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleButtonText = document.getElementById('password-text');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButtonText.textContent = 'Ẩn';
            } else {
                passwordField.type = 'password';
                toggleButtonText.textContent = 'Hiện';
            }
        }

        document.getElementById('toggle-password').addEventListener('click', togglePasswordVisibility);
    </script>
@endsection
