@extends('layouts.app')

@section('content')
<div class="min-h-screen">
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
                    <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                        <li><a href="#" class="block px-2 py-3">Account</a></li>
                        <li><a href="#" class="block px-2 py-3">Voucher</a></li>
                        <li><a href="#" class="block px-2 py-3">Order History</a></li>
                    </ul>
                    <div class="border-t border-gray-200 px-4 py-6">
                        <button type="submit" class="w-full bg-gray-900 py-2 text-white hover:bg-gray-700">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <main class="mx-auto max-w-7xl mt-14 px-4 sm:px-6 lg:px-4">
        <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
            <h1 class="text-3xl pb-3 font-bold tracking-tight text-gray-900">Personal Account</h1> <!-- Hiển thị tên khách hàng -->
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
            <ul role="list" class="space-y-4  border-gray-200 pb-6 text-sm font-medium text-gray-900">
              <li>
                <a href="#">Account</a>
              </li>
              <li>
                <a href="#">Voucher</a>
              </li>
              <li>
                <a href="#">Order History</a>
              </li>
            </ul>
          </form>

                <div class="col-span-3 border-l">    
                <div class="flex-1 lg:pr-8 pb-8 w-full max-xl:max-w-3xl max-xl:mx-auto">
                        <div class="flex flex-col bg-white px-7  gap-4 md:gap-4">
                        <div class="grid grid-cols-2 justify-between space-x-4">
                            <div class="mb-2">
                                <div class="relative flex flex-col">
                                    <label for="full_name" class="mb-2 block text-sm font-medium text-gray-900"> Họ và tên </label>
                                    <input name="name" value="{{ Auth::check() ? Auth::user()->HoTen : '' }}" type="text" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Enter full name" />
                                </div>
                            </div>
                            <div class="mb-2">
                            <div class="relative flex flex-col">
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-900"> Email </label>
                                <input value="{{ Auth::check() ? Auth::user()->Email : '' }}" name="email" type="text" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Enter email" />
                            </div>
                        </div>
                        </div>

                        <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                        <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                        <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">
                        <div class="mt-2 mb-2">
                            <div class="relative flex flex-col justify-between">
                            <label for="phone_number" class="mb-2 block text-sm font-medium text-gray-900"> Số điện thoại</label>
                                <input value="{{ Auth::check() ? Auth::user()->SDT : '' }}" name="phone_number" type="text" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Enter phone number" />
                            </div>
                        </div>
                    <div>
                        <div class="col-span-1 md:col-span-4 mb-5">
                        <label for="diachi" class="mb-2 block text-sm font-medium text-gray-900"> Địa chỉ </label>
                            <input 
                                type="text" 
                                id="diachi" 
                                name="diachinha" 
                                placeholder="Nhập địa chỉ" 
                                required 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            />
                            <div id="diachiError" class="text-red-600 text-sm mt-1">
                                {{ $errors->first('diachi') }}
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 items-center justify-center">
                        <!-- Input for address -->
                        <!-- Select for Tỉnh -->
                        <div class="col-span-1">
                            <input type="hidden" id="hidden_tinh" name="hidden_tinh" value="">
                            <label for="tinh" class="mb-2 block text-sm font-medium text-gray-900"> Tỉnh </label>
                            <select 
                                id="tinh" 
                                name="tinh" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn tỉnh</option>
                                <!-- populate options with data from your database or API -->
                            </select>
                        </div>

                        <!-- Select for Quận/Huyện -->
                        <div class="col-span-1">
                            <input type="hidden" id="hidden_quan" name="hidden_quan" value="">
                            <label for="quan" class="mb-2 block text-sm font-medium text-gray-900"> Quận/Huyện </label>
                            <select 
                                id="quan" 
                                name="quan" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn quận/huyện</option>
                            </select>
                        </div>

                        <!-- Select for Xã/Phường -->
                        <div class="col-span-1">
                            <input type="hidden" id="hidden_phuong" name="hidden_phuong" value="">
                            <label for="phuong" class="mb-2 block text-sm font-medium text-gray-900"> Phường/Xã</label>
                            <select 
                                id="phuong" 
                                name="phuong" 
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                            >
                                <option value="">Chọn xã/phường</option>
                            </select>
                        </div>
                    
                    </div>
                    
                    
                    <label for="Message" class="mb-2 block text-sm mt-7 font-medium text-gray-900"> Ghi chú</label>
                        <textarea placeholder='Message' rows="6"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-200 dark:bg-gray-100  dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"></textarea>
                        </div>
                        </div>
                </div>
            </div>
        </section>
    </main>
</div>
@endsection
