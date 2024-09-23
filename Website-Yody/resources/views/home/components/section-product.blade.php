@php

    // Dữ liệu mô phỏng sản phẩm
    $products = [
        ['productName' => 'Áo đẹp qua neeee', 'price' => 1000, 'image' => 'https://m.yodycdn.com/fit-in/filters:format(webp)/products/set6054-den-8.jpg'],
        ['productName' => 'Product 2', 'price' => 2000, 'image' => 'https://m.yodycdn.com/fit-in/filters:format(webp)/products/set6054-xah-5.jpg'],
        ['productName' => 'Product 3', 'price' => 3000, 'image' => 'https://m.yodycdn.com/fit-in/filters:format(webp)/products/swn6004-den-sdn6314-bed-04.jpg'],
    ];
@endphp
<script>
    let days = 2;    // Số ngày bắt đầu
let hours = 5;   // Số giờ bắt đầu
let minutes = 10; // Số phút bắt đầu
let seconds = 24; // Số giây bắt đầu

const countdownElement = document.querySelector('.countdown');

const timer = setInterval(() => {
    if (seconds === 0) {
        if (minutes === 0) {
            if (hours === 0) {
                if (days === 0) {
                    clearInterval(timer);
                    countdownElement.innerHTML = "Time's up!";
                    return;
                }
                days--;
                hours = 23; // Đặt lại giờ thành 23
                minutes = 59; // Đặt lại phút thành 59
                seconds = 59; // Đặt lại giây thành 59
            } else {
                minutes--;
                seconds = 59;
            }
        } else {
            minutes--;
            seconds = 59;
        }
    } else {
        seconds--;
    }

    // Cập nhật hiển thị
    document.getElementById('days').innerText = String(days).padStart(2, '0');
    document.getElementById('hours').innerText = String(hours).padStart(2, '0');
    document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
    document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
}, 1000);

</script>
<div class="text-center p-5 lg:px-24 mt-12">
    <div class="mb-5">
        <div class="bg-black">
            <div class="countdown text-4xl bg-black">
                <div class="flex justify-center text-white space-x-2 p-3">
                    <span class="flex flex-col items-center">
                        <span id="days">00</span>
                        <span class="text-sm mt-1">Days</span>
                    </span>
                    <span>:</span>
                    <span class="flex flex-col items-center">
                        <span id="hours">00</span>
                        <span class="text-sm mt-1">Hours</span>
                    </span>
                    <span>:</span>
                    <span class="flex flex-col items-center">
                        <span id="minutes">10</span>
                        <span class="text-sm mt-1">Minutes</span>
                    </span>
                    <span>:</span>
                    <span class="flex flex-col items-center">
                        <span id="seconds">24</span>
                        <span class="text-sm mt-1">Seconds</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="flex flex-col items-center lg:flex-row lg:space-x-5 justify-center">
            <h3 class="text-2xl lg:text-6xl uppercase font-bold">SALE OF THE YEAR</h3>
            <a href="/products" class="bg-primary text-white px-4 py-2 mt-5 lg:mt-0 bg-blue-900 rounded-full shadow-md hover:bg-blue-800 duration-200">Shop Now</a>
        </div>

        <div class="grid gap-7 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($chiTietSanPhams as $chiTietSanPham)  
                <div class="border p-5 rounded cursor-pointer hover:border-2 duration-150">
                     <img src="{{ asset('images/products/' . $chiTietSanPham->HinhAnh) }}" alt="" class="w-full h-auto">
                    <h4 class="font-bold flex justify-start mt-3">{{ $chiTietSanPham->SanPham->TenSP }}</h4>
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
</div>