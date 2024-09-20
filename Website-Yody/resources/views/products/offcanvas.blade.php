<div class="fixed inset-0 z-40 hidden lg:hidden" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>
  <div class="fixed inset-0 z-40 flex">
    <div class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
      <div class="flex items-center justify-between px-4">
        <h2 class="text-lg font-medium text-gray-900">Filters</h2>
        <button class="focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <form class="mt-4 border-t border-gray-200">
        <h3 class="sr-only">Categories</h3>
        <ul role="list" class="px-2 py-3 font-medium text-gray-900">
          <li><a href="#" class="block px-2 py-3">Totes</a></li>
          <li><a href="#" class="block px-2 py-3">Backpacks</a></li>
          <li><a href="#" class="block px-2 py-3">Travel Bags</a></li>
          <li><a href="#" class="block px-2 py-3">Hip Bags</a></li>
          <li><a href="#" class="block px-2 py-3">Laptop Sleeves</a></li>
        </ul>

        <div class="border-t border-gray-200 px-4 py-6">
          <h3 class="-mx-2 -my-3 flow-root">
            <button type="button" class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500" aria-controls="filter-section-mobile-0" aria-expanded="false">
              <span class="font-medium text-gray-900">Color</span>
              <span class="ml-6 flex items-center">
                <span class="text-xl" id="expand-icon-0">+</span>
                <span class="text-xl hidden" id="collapse-icon-0">-</span>
              </span>
            </button>
          </h3>
          <div class="pt-6 hidden" id="filter-section-mobile-0">
            <div class="space-y-6">
              <div class="flex items-center">
                <input id="filter-mobile-color-0" name="color[]" value="white" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-color-0" class="ml-3 min-w-0 flex-1 text-gray-500">White</label>
              </div>
              <div class="flex items-center">
                <input id="filter-mobile-color-1" name="color[]" value="beige" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-color-1" class="ml-3 min-w-0 flex-1 text-gray-500">Beige</label>
              </div>
              <div class="flex items-center">
                <input id="filter-mobile-color-2" name="color[]" value="blue" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-color-2" class="ml-3 min-w-0 flex-1 text-gray-500">Blue</label>
              </div>
              <div class="flex items-center">
                <input id="filter-mobile-color-3" name="color[]" value="brown" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-color-3" class="ml-3 min-w-0 flex-1 text-gray-500">Brown</label>
              </div>
              <div class="flex items-center">
                <input id="filter-mobile-color-4" name="color[]" value="green" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-color-4" class="ml-3 min-w-0 flex-1 text-gray-500">Green</label>
              </div>
              <div class="flex items-center">
                <input id="filter-mobile-color-5" name="color[]" value="purple" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-color-5" class="ml-3 min-w-0 flex-1 text-gray-500">Purple</label>
              </div>
            </div>
          </div>
        </div>

        <div class="border-t border-gray-200 px-4 py-6">
          <h3 class="-mx-2 -my-3 flow-root">
            <button type="button" class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500" aria-controls="filter-section-mobile-2" aria-expanded="false">
              <span class="font-medium text-gray-900">Size</span>
              <span class="ml-6 flex items-center">
                <span class="text-xl" id="expand-icon-1">+</span>
                <span class="text-xl hidden" id="collapse-icon-1">-</span>
              </span>
            </button>
          </h3>
          <div class="pt-6 hidden" id="filter-section-mobile-2">
            <div class="space-y-6">
              <div class="flex items-center">
                <input id="filter-mobile-size-0" name="size[]" value="2l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-size-0" class="ml-3 min-w-0 flex-1 text-gray-500">2L</label>
              </div>
              <div class="flex items-center">
                <input id="filter-mobile-size-1" name="size[]" value="6l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-size-1" class="ml-3 min-w-0 flex-1 text-gray-500">6L</label>
              </div>
              <div class="flex items-center">
                <input id="filter-mobile-size-2" name="size[]" value="12l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-size-2" class="ml-3 min-w-0 flex-1 text-gray-500">12L</label>
              </div>
              <div class="flex items-center">
                <input id="filter-mobile-size-3" name="size[]" value="18l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="filter-mobile-size-3" class="ml-3 min-w-0 flex-1 text-gray-500">18L</label>
              </div>
            </div>
          </div>
        </div>

        <div class="border-t border-gray-200 px-4 py-6">
          <button type="submit" class="w-full bg-gray-900 py-2 text-white hover:bg-gray-700">Apply Filters</button>
        </div>
      </form>
    </div>
  </div>
</div>