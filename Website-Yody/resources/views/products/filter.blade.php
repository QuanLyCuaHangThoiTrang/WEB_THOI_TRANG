<form class="hidden lg:block">
    <!-- Color Filter Section -->
    <div class="border-b border-gray-200 py-6">
        <h3 class="-my-3 flow-root">
            <button type="button"
                class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                aria-controls="filter-section-0" aria-expanded="true">
                <span class="font-medium text-xl text-gray-900">Màu sắc</span>
                <span class="ml-6 flex items-center">
                    <span class="text-xl hidden" id="expand-icon-0">+</span>
                    <span class="text-xl" id="collapse-icon-0">-</span>
                </span>
            </button>
        </h3>
        <!-- Display the color filter section by default -->
        <div class="pt-6" id="filter-section-0">
            <div class="grid grid-cols-4 gap-4">
                @foreach ($MauSacs as $item)
                    <div class="flex items-center justify-center">
                        <!-- Ẩn checkbox nhưng vẫn để nó nhận giá trị khi người dùng chọn -->
                        <input id="filter-color-{{ $loop->index }}" name="color[]" value="{{ $item->TenMau }}"
                            type="checkbox" class="hidden custom-checkbox1">

                        <!-- Hộp màu mà người dùng sẽ nhấp vào -->
                        <label for="filter-color-{{ $loop->index }}"
                            class="ml-3 text-sm text-gray-600 flex flex-col items-center cursor-pointer">
                            <span
                                class="inline-block hover:scale-110 duration-200 h-14 w-14 rounded-full mb-2 border border-gray-300"
                                style="background-color: {{ $item->TenMau }};"></span>

                        </label>
                    </div>
                @endforeach


            </div>

        </div>

    </div>

    <!-- Size Filter Section -->
    <div class="border-b border-gray-200 py-6">
        <h3 class="-my-3 flow-root">
            <button type="button"
                class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
                aria-controls="filter-section-2" aria-expanded="true">
                <span class="font-medium text-xl text-gray-900">Kích cỡ</span>
                <span class="ml-6 flex items-center">
                    <span class="text-xl hidden" id="expand-icon-2">+</span>
                    <span class="text-xl" id="collapse-icon-2">-</span>
                </span>
            </button>
        </h3>
        <!-- Display the size filter section by default -->
        <div class="pt-6" id="filter-section-2">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach ($KichThuocs as $item)
                    <div class="flex items-center space-x-4">
                        <label for="filter-size-{{ $loop->index }}" class="flex items-center cursor-pointer space-x-2">
                            <input id="filter-size-{{ $loop->index }}" name="size[]" value="{{ $item->TenSize }}"
                                type="checkbox" class="hidden custom-checkbox">
                            <span
                                class="inline-flex items-center justify-center w-16 gap-4 space-x-4 space-y-4 h-10 border hover:scale-110 duration-200 rounded-xl text-lg cursor-pointer">
                                {{ $item->TenSize }}
                            </span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
