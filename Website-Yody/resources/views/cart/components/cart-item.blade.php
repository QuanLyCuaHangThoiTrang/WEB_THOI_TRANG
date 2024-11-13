<!-- resources/views/components/cart-item.blade.php -->
<div class="flex bg-white px-4 py-6 border-b border-gray-200 gap-4 md:gap-8 items-center">
    <a href="{{ route('cart.remove', ['MaGH' => $chitiet->MaGH, 'MaCTSP' => $chitiet->MaCTSP]) }}"
        class="remove-item text-red-500 hover:text-red-700 flex items-center">
        <!-- SVG Icon -->
    </a>
    <div class="w-full md:max-w-[150px]">
        <img src="{{ asset('images/products/' . $chitiet->ChiTietSanPham->HinhAnh) }}" alt="product image"
            class="w-full h-auto rounded-xl object-cover">
    </div>
    <div class="flex-1 md:flex md:items-center">
        <div class="flex flex-col gap-2">
            <h6 class="font-semibold text-base leading-7">{{ $chitiet->chiTietSanPham->sanPham->TenSP }}</h6>
            <h6 class="font-medium text-base leading-7 text-gray-600">{{ $chitiet->DonGia }}</h6>
            <button class="btn bg-gray-100 flex p-1 w-fit rounded-lg">
                <span class="font-semibold">{{ $chitiet->chiTietSanPham->mauSac->TenMau }},
                    {{ $chitiet->chiTietSanPham->KichThuoc->TenSize }}</span>
                <span class="inline-block pl-2 pt-1">
                    <x-icons.icon name="chevron-down" />
                </span>
            </button>
        </div>
        @include('cart.components.quantity-control')
    </div>
</div>
