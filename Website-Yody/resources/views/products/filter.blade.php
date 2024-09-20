<form class="hidden lg:block">
            <ul role="list" class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">
              <li>
                <a href="#">Totes</a>
              </li>
              <li>
                <a href="#">Backpacks</a>
              </li>
              <li>
                <a href="#">Travel Bags</a>
              </li>
              <li>
                <a href="#">Hip Bags</a>
              </li>
              <li>
                <a href="#">Laptop Sleeves</a>
              </li>
            </ul>

            <div class="border-b border-gray-200 py-6">
                <h3 class="-my-3 flow-root">
                    <!-- Expand/collapse section button -->
                    <button type="button" class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-0" aria-expanded="false">
                    <span class="font-medium text-gray-900">Color</span>
                    <span class="ml-6 flex items-center">
                        <!-- Expand icon, show/hide based on section open state. -->
                        <span class="text-xl" id="expand-icon-0">+</span>
                        <!-- Collapse icon, show/hide based on section open state. -->
                        <span class="text-xl hidden" id="collapse-icon-0">-</span>
                    </span>
                    </button>
                </h3>
                <!-- Filter section, show/hide based on section state. -->
                <div class="pt-6 hidden" id="filter-section-0">
                    <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="filter-color-0" name="color[]" value="white" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-color-0" class="ml-3 text-sm text-gray-600">White</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-color-1" name="color[]" value="beige" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-color-1" class="ml-3 text-sm text-gray-600">Beige</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-color-2" name="color[]" value="blue" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-color-2" class="ml-3 text-sm text-gray-600">Blue</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-color-3" name="color[]" value="brown" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-color-3" class="ml-3 text-sm text-gray-600">Brown</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-color-4" name="color[]" value="green" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-color-4" class="ml-3 text-sm text-gray-600">Green</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-color-5" name="color[]" value="purple" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-color-5" class="ml-3 text-sm text-gray-600">Purple</label>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Category Filter Section -->
                <div class="border-b border-gray-200 py-6">
                <h3 class="-my-3 flow-root">
                    <!-- Expand/collapse section button -->
                    <button type="button" class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-1" aria-expanded="false">
                    <span class="font-medium text-gray-900">Category</span>
                    <span class="ml-6 flex items-center">
                        <!-- Expand icon, show/hide based on section open state. -->
                        <span class="text-xl" id="expand-icon-1">+</span>
                        <!-- Collapse icon, show/hide based on section open state. -->
                        <span class="text-xl hidden" id="collapse-icon-1">-</span>
                    </span>
                    </button>
                </h3>
                <!-- Filter section, show/hide based on section state. -->
                <div class="pt-6 hidden" id="filter-section-1">
                    <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="filter-category-0" name="category[]" value="new-arrivals" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-category-0" class="ml-3 text-sm text-gray-600">New Arrivals</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-category-1" name="category[]" value="sale" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-category-1" class="ml-3 text-sm text-gray-600">Sale</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-category-2" name="category[]" value="travel" type="checkbox" checked class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-category-2" class="ml-3 text-sm text-gray-600">Travel</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-category-3" name="category[]" value="organization" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-category-3" class="ml-3 text-sm text-gray-600">Organization</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-category-4" name="category[]" value="accessories" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-category-4" class="ml-3 text-sm text-gray-600">Accessories</label>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Size Filter Section -->
                <div class="border-b border-gray-200 py-6">
                <h3 class="-my-3 flow-root">
                    <!-- Expand/collapse section button -->
                    <button type="button" class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-2" aria-expanded="false">
                    <span class="font-medium text-gray-900">Size</span>
                    <span class="ml-6 flex items-center">
                        <!-- Expand icon, show/hide based on section open state. -->
                        <span class="text-xl" id="expand-icon-2">+</span>
                        <!-- Collapse icon, show/hide based on section open state. -->
                        <span class="text-xl hidden" id="collapse-icon-2">-</span>
                    </span>
                    </button>
                </h3>
                <!-- Filter section, show/hide based on section state. -->
                <div class="pt-6 hidden" id="filter-section-2">
                    <div class="space-y-4">
                    <div class="flex items-center">
                        <input id="filter-size-0" name="size[]" value="2l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-size-0" class="ml-3 text-sm text-gray-600">2L</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-size-1" name="size[]" value="6l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-size-1" class="ml-3 text-sm text-gray-600">6L</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-size-2" name="size[]" value="12l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-size-2" class="ml-3 text-sm text-gray-600">12L</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-size-3" name="size[]" value="15l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-size-3" class="ml-3 text-sm text-gray-600">15L</label>
                    </div>
                    <div class="flex items-center">
                        <input id="filter-size-4" name="size[]" value="18l" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="filter-size-4" class="ml-3 text-sm text-gray-600">18L</label>
                    </div>
                    </div>
                </div>
                </div>
          </form>