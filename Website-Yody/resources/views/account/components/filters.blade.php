<div id="canvas-filter" class="fixed inset-0 z-50 lg:hidden hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>
    <div class="fixed inset-0 z-50 flex">
        <div class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-6 pb-12 shadow-xl rounded-lg">
            <div class="flex items-center justify-between px-6">
                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                <button class="focus:outline-none" id="close-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-gray-900 transition duration-150">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form class="mt-4 border-t border-gray-200">
                <h3 class="sr-only">Categories</h3>
                <div>
                    <ul role="list" class="space-y-4 border-gray-200 pb-6 text-sm font-medium text-gray-900">
                        <li>
                            <a href="#">Account</a>
                        </li>
                        <li>
                            <a href="#">Address</a>
                        </li>
                        <li>
                            <a href="#">Voucher</a>
                        </li>
                        <li>
                            <a href="#">Order History</a>
                        </li>
                    </ul>
                </div>
                <div class="border-t border-gray-200 px-6 py-4">
                    <button type="submit" class="button bg-gray-900 py-2 text-white hover:bg-gray-700 transition duration-200 rounded-md shadow-md">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>