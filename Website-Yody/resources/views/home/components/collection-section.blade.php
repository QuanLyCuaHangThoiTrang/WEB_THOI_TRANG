<div class="space-y-2 px-8 lg:px-24">
    <div class="grid gap-7 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

        @foreach ($chiTietSanPhams as $chiTietSanPham)  
            <div class="border p-5 rounded cursor-pointer hover:border-2 duration-150 flex flex-col">
                <div>
                    <img src="{{ asset('images/products/' . $chiTietSanPham->HinhAnh) }}" alt="" class="w-full h-auto min-w-screen">
                </div>
                <h4 class="font-bold flex-grow mt-3 truncate">{{ $chiTietSanPham->SanPham->TenSP }}</h4>
                <div class="flex flex-col">
                    <div class="flex mt-1">
                        <p class="text-lg">{{ $chiTietSanPham->SanPham->GiaBan }} VND</p> 
                        <p class="text-white font-medium text-sm ml-auto border rounded-3xl bg-red-500 hover:text-white px-2 py-1 transition duration-150">-10%</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
