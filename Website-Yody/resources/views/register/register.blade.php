@extends('layouts.app')
@section('content')
<div class=" mt-20 bg-slate-200 py-2">
    <div class="flex flex-col items-center justify-center">
        <div class="font-[sans-serif] grid md:grid-cols-2 items-center bg-white gap-4 max-md:gap-8 max-w-5xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
            <div class="md:max-w-md w-full px-4">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-12">
                        <h3 class="text-gray-800 text-3xl font-extrabold">Create an account</h3>
                        <p class="text-sm mt-4 text-gray-800">Have an account <a href="{{ url('/login') }}" class="text-yellow-600 font-semibold hover:underline ml-1 whitespace-nowrap">Login here</a></p>
                    </div>

                    <!-- Full Name -->
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Full Name</label>
                        <div class="relative flex items-center">
                            <input name="full_name" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter full name" />
                        </div>
                        @error('full_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Username</label>
                        <div class="relative flex items-center">
                            <input name="username" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter username" />
                        </div>
                        @error('username')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Phone Number</label>
                        <div class="relative flex items-center">
                            <input name="phone_number" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter phone number" />
                        </div>
                        @error('phone_number')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="text-gray-800 text-xs block mb-2">Email</label>
                        <div class="relative flex items-center">
                            <input name="email" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter email" />
                        </div>
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label class="text-gray-800 text-xs block mb-2">Password</label>
                        <div class="relative flex items-center">
                            <input name="password" type="text" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Enter password" />
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label class="text-gray-800 text-xs block mb-2">Confirm Password</label>
                        <div class="relative flex items-center">
                            <input name="password_confirmation" type="password" required class="w-full text-gray-800 text-sm border-b border-gray-300 focus:border-blue-600 px-2 py-3 outline-none" placeholder="Confirm password" />
                        </div>
                        @error('password_confirmation')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-md text-white bg-yellow-500 hover:bg-yellow-600 duration-150 focus:outline-none">
                            Sign up
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
