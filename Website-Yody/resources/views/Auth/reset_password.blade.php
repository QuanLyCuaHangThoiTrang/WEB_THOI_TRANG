@extends('layouts.app')

@section('content')
<div class="font-[sans-serif] bg-slate-200 py-2 mt-20">
    <div class="flex flex-col items-center justify-center">
        <div class="grid md:grid-cols-1 items-center bg-white gap-4 max-w-lg w-full p-4 m-4 shadow-lg rounded-lg">
            <div class="md:max-w-md w-full px-4">
                <form action="{{ route('password.reset') }}" method="POST">
                    @csrf
                    <div class="mb-12">
                        <h3 class="text-gray-800 text-3xl font-bold">Đặt lại mật khẩu</h3>
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
                        <input name="email" type="email" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none transition duration-200" placeholder="Nhập email" value="{{ $email }}">
                        <input name="email" type="hidden" value="{{ $email }}">
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Mật khẩu mới</label>
                        <input name="password" type="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none transition duration-200" placeholder="Nhập mật khẩu mới" />
                    </div>
                    
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Xác nhận mật khẩu</label>
                        <input name="password_confirmation" type="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none transition duration-200" placeholder="Xác nhận mật khẩu mới" />
                    </div>
                    

                    <div class="mt-12">
                        <button type="submit" class="w-full shadow-lg py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-yellow-500 duration-150 focus:outline-none transition-transform transform hover:scale-105">
                            Đặt lại mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
