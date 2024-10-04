<form class="hidden lg:block">
            
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
                        @foreach ($MauSacs as $item)
                        <div class="flex items-center">
                            <input id="filter-color-{{ $loop->index }}" name="color[]" value="{{ $item->TenMau }}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="filter-color-{{ $loop->index }}" class="ml-3 text-sm text-gray-600">{{ $item->TenMau }}</label>
                        </div>    
                        @endforeach
                                       
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
                      @foreach ($KichThuocs as $item)
                          <div class="flex items-center">
                              <input id="filter-size-{{ $loop->index }}" name="size[]" value="{{ $item->TenSize }}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                              <label for="filter-size-{{ $loop->index }}" class="ml-3 text-sm text-gray-600">{{ $item->TenSize }}</label>
                          </div>
                      @endforeach
                    </div>
                </div>
                </div>
          </form>