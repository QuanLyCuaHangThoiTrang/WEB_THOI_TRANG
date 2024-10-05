<main class="mx-auto max-w-7xl px-4 mt-14">
    <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
        <h1 class="text-4xl pb-3 font-bold tracking-tight text-gray-900">Account Settings</h1>
        <div class="flex items-center pt-4">
            <button id="filter-button" class="ml-4 lg:hidden text-gray-700 hover:text-gray-900 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>
            </button>
        </div>
    </div>

    <section aria-labelledby="account-details-heading" class="pb-24 pt-6">
        <div class="grid grid-cols-1 gap-y-10 lg:grid-cols-4">
            <!-- Filters for larger screens -->
            <form class="hidden lg:block">
                <div>
                    <ul role="list" class="space-y-4 border-gray-200 pb-6 text-sm font-medium text-gray-900">
                        <li>
                            <a href="{{ url('/account/' . $khachhang->MaKH) }}">Account</a>
                        </li>
                        <li>
                            <a href="{{ url('/addresses/' . $khachhang->MaKH) }}">Address</a>
                        </li>
                        <li>
                            <a href={{ url('/voucher/{MaKH}') }}">Voucher</a>
                        </li>
                        <li>
                            <a href="{{ url('/order-history/{MaKH}') }}">Order History</a>
                        </li>
                    </ul>
                </div>
            </form>

            <div class="col-span-3 bg-white border-l rounded-lg shadow-md">
                <div class="bg-blue-950 w-full py-2 relative rounded-t-lg"></div>
                <div class="flex-1 pb-8 w-full max-xl:max-w-3xl max-xl:mx-auto">
                    <!-- Account Details Section -->
                    <div class="flex flex-col  px-7 gap-4 md:gap-4 p-6 mb-6">
                        <div class="border-b">
                            <h3 class="text-3xl font-semibold text-gray-900 mb-4" id="account-details-heading">Account Details</h3>
                        </div>
                        <form action="{{ route('account.updateAccount', $khachhang->MaKH) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="full_name" class="block py-2 text-sm font-medium text-gray-700">Tên khách hàng</label>
                                <input id="full_name" name="full_name" value="{{ Auth::check() ? Auth::user()->HoTen : '' }}" type="text" required class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600  duration-500 focus:outline-none rounded-md" placeholder="Enter full name" />
                            </div>
                            <div class="mb-4">
                                <label for="taikhoan" class="block text-sm py-2 font-medium text-gray-700">Tài khoản</label>
                                <input id="taikoan" name="taikhoan" value="{{ Auth::check() ? Auth::user()->Username : '' }}" type="text" required class="w-full border-2 border-gray-300 border-l-[7px] py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600  duration-500 focus:outline-none rounded-md" placeholder="Enter user name" />
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm py-2 font-medium text-gray-700">Email</label>
                                <input id="email" name="email" value="{{ Auth::check() ? Auth::user()->Email : '' }}" type="text" required class="w-full border-2 border-gray-300 border-l-[7px]  py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600  duration-500 focus:outline-none rounded-md" placeholder="Enter email" />
                            </div>
                           
                            <!-- Save Changes Button -->
                            <div class="mt-4">
                                <button type="submit" class="button bg-blue-900 px-16 py-2 text-white hover:bg-blue-500 transition duration-200 rounded-md shadow-md">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="bg-blue-950 w-full py-2 relative"></div>
                    <!-- Password Update Section -->
                    <div class="flex flex-col  px-7 gap-4 md:gap-4 p-6">
                        <div class="border-b">
                            <h3 class="text-3xl font-semibold text-gray-900 mb-4" id="account-details-heading">Change Password</h3>
                        </div>
                        @if(!$isGoogleAccount)
                        <form action="{{ route('account.updateAccount', $khachhang->MaKH) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="new_password" class="block text-sm font-medium py-2 text-gray-700">Mật khẩu mới</label>
                                <input name="new_password" type="password" class="w-full border-2 border-gray-300 py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600  duration-500 border-l-[7px] focus:outline-none rounded-md" placeholder="Enter new password">
                            </div>
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="block text-sm py-2 font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                                <input name="new_password_confirmation" type="password" class="w-full border-2 border-gray-300 py-3 px-4 text-base text-gray-700 placeholder-gray-400 focus:border-black hover:border-gray-600  duration-500 border-l-[7px] focus:outline-none rounded-md" placeholder="Confirm new password">
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="button bg-blue-900 px-16 py-2 text-white hover:bg-blue-500 transition duration-200 rounded-md shadow-md">Save</button>
                            </div>
                        </form>
                        @else
                        <div class="mt-4 text-red-600">
                            Tài khoản Google không thể thay đổi mật khẩu.
                        </div>
                        @endif
                    </div>
                    <div class="bg-blue-950 w-full py-2 relative"></div>
                    <!-- Account Deletion Section -->
                    {{-- <div class="mb-10 px-7 mt-4">
                        <p class="py-2 text-xl  font-semibold">Delete Account</p>
                        <p class="inline-flex items-center rounded-full py-1 text-rose-600">
                          <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-10a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V8zm1-4a1 1 0 1 1 1 1 1 1 0 0 1-1-1z" clip-rule="evenodd" />
                          </svg>
                          Tài khoản của bạn sẽ được xóa vĩnh viễn No longer want to use our service? You can delete your account here. This action is not reversible. All information related to this account will be deleted permanently.
                        </p>
                        <form action="{{ route('account.delete', $khachhang->MaKH) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mt-4 rounded-md bg-red-600 py-2 px-8 text-white hover:bg-red-800">Xóa tài khoản</button>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
    if (!confirm('Bạn có chắc chắn muốn xóa tài khoản của mình không? Hành động này sẽ không thể khôi phục.')) {
        e.preventDefault();
    }
});
</script>