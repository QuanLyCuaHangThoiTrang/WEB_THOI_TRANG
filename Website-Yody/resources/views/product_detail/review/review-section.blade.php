<div class="mt-8">
    <h3 class="text-xl font-bold text-gray-800">Tổng số đánh giá ({{ $tongSoDanhGia }})</h3>
    <div class="space-y-3 mt-4">
        @php
            $tongSoDanhGia = $danhGias->count();
            $danhGia5Sao = $danhGias->where('DiemDanhGia', 5)->count();
            $danhGia4Sao = $danhGias->where('DiemDanhGia', 4)->count();
            $danhGia3Sao = $danhGias->where('DiemDanhGia', 3)->count();
            $danhGia2Sao = $danhGias->where('DiemDanhGia', 2)->count();
            $danhGia1Sao = $danhGias->where('DiemDanhGia', 1)->count();

            $phanTram5Sao = $tongSoDanhGia > 0 ? ($danhGia5Sao / $tongSoDanhGia) * 100 : 0;
            $phanTram4Sao = $tongSoDanhGia > 0 ? ($danhGia4Sao / $tongSoDanhGia) * 100 : 0;
            $phanTram3Sao = $tongSoDanhGia > 0 ? ($danhGia3Sao / $tongSoDanhGia) * 100 : 0;
            $phanTram2Sao = $tongSoDanhGia > 0 ? ($danhGia2Sao / $tongSoDanhGia) * 100 : 0;
            $phanTram1Sao = $tongSoDanhGia > 0 ? ($danhGia1Sao / $tongSoDanhGia) * 100 : 0;
        @endphp

        <div class="flex items-center">
            <p class="text-sm text-gray-800 font-bold">5.0</p>
            <svg class="w-5 fill-yellow-500 ml-1.5" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z" />
            </svg>
            <div class="bg-gray-300 rounded-md w-full h-2 ml-3">
                <div class="h-full rounded-md bg-yellow-500" style="width: {{ $phanTram5Sao }}%;"></div>
            </div>
            <p class="text-sm text-gray-800 font-bold ml-3">{{ round($phanTram5Sao, 1) }}%</p>
        </div>

        <div class="flex items-center">
            <p class="text-sm text-gray-800 font-bold">4.0</p>
            <svg class="w-5 fill-yellow-500 ml-1.5" viewBox="0 0 14 13" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z" />
            </svg>
            <div class="bg-gray-300 rounded-md w-full h-2 ml-3">
                <div class="h-full rounded-md bg-yellow-500" style="width: {{ $phanTram4Sao }}%;"></div>
            </div>
            <p class="text-sm text-gray-800 font-bold ml-3">{{ round($phanTram4Sao, 1) }}%</p>
        </div>

        <div class="flex items-center">
            <p class="text-sm text-gray-800 font-bold">3.0</p>
            <svg class="w-5 fill-yellow-500 ml-1.5" viewBox="0 0 14 13" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z" />
            </svg>
            <div class="bg-gray-300 rounded-md w-full h-2 ml-3">
                <div class="h-full rounded-md bg-yellow-500" style="width: {{ $phanTram3Sao }}%;"></div>
            </div>
            <p class="text-sm text-gray-800 font-bold ml-3">{{ round($phanTram3Sao, 1) }}%</p>
        </div>

        <div class="flex items-center">
            <p class="text-sm text-gray-800 font-bold">2.0</p>
            <svg class="w-5 fill-yellow-500 ml-1.5" viewBox="0 0 14 13" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z" />
            </svg>
            <div class="bg-gray-300 rounded-md w-full h-2 ml-3">
                <div class="h-full rounded-md bg-yellow-500" style="width: {{ $phanTram2Sao }}%;"></div>
            </div>
            <p class="text-sm text-gray-800 font-bold ml-3">{{ round($phanTram2Sao, 1) }}%</p>
        </div>

        <div class="flex items-center">
            <p class="text-sm text-gray-800 font-bold">1.0</p>
            <svg class="w-5 fill-yellow-500 ml-1.5" viewBox="0 0 14 13" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z" />
            </svg>
            <div class="bg-gray-300 rounded-md w-full h-2 ml-3">
                <div class="h-full rounded-md bg-yellow-500" style="width: {{ $phanTram1Sao }}%;"></div>
            </div>
            <p class="text-sm text-gray-800 font-bold ml-3">{{ round($phanTram1Sao, 1) }}%</p>
        </div>
    </div>

    <button id="toggleReviews" type="button"
        class="w-full mt-8 px-6 py-2.5 border border-yellow-600 bg-transparent text-gray-800 text-sm font-semibold rounded-md">Đọc
        các đánh giá</button>

    <div id="reviewDetails" class="mt-4 hidden transition-all duration-500 transform opacity-0 translate-y-4">
        <div class="border-t border-gray-300 mt-4 pt-4">
            <div class="mt-2">
                @if ($danhGias->isEmpty())
                    <p class="text-gray-600">Chưa có đánh giá nào cho sản phẩm này.</p>
                @else
                    @foreach ($danhGias as $danhGia)
                        <div class="border-b border-gray-300 pb-4 space-y-2 mb-4">
                            <p class="font-semibold text-gray-800">{{ $danhGia->khachHang->HoTen }}</p>
                            <div class="flex items-center">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $danhGia->DiemDanhGia ? 'fill-yellow-500' : 'fill-gray-300' }}"
                                            viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7 0L9.4687 3.60213L13.6574 4.83688L10.9944 8.29787L11.1145 12.6631L7 11.2L2.8855 12.6631L3.00556 8.29787L0.342604 4.83688L4.5313 3.60213L7 0Z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $danhGia->NoiDung }}</p>
                            <p class="text-xs text-gray-500 mt-1">Được đánh giá vào {{ $danhGia->NgayDanhGia }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</div>


<script>
    document.getElementById('toggleReviews').addEventListener('click', function() {
        const reviewDetails = document.getElementById('reviewDetails');

        if (reviewDetails.classList.contains('hidden')) {
            reviewDetails.classList.remove('hidden');
            setTimeout(() => {
                reviewDetails.classList.remove('opacity-0', 'translate-y-0');
                reviewDetails.classList.add('opacity-100', 'translate-y-4');
            }, 10); // Thực hiện một độ trễ nhỏ để hiệu ứng chuyển tiếp hoạt động
        } else {
            reviewDetails.classList.add('opacity-0', 'translate-y-4');
            reviewDetails.classList.remove('opacity-100', 'translate-y-0');
            setTimeout(() => {
                reviewDetails.classList.add('hidden');
            }, 500); // Thực hiện ẩn phần tử sau khi hiệu ứng kết thúc
        }
    });
</script>
