<script>
    let days = 2;    
    let hours = 5;   
    let minutes = 10; 
    let seconds = 24; 

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
                    hours = 23; 
                    minutes = 59; 
                    seconds = 59; 
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
        <div class="bg-black p-5 rounded-lg">
            <div class="countdown text-4xl text-white">
                <div class="flex justify-center space-x-4">
                    <span class="flex flex-col items-center">
                        <span id="days">00</span>
                        <span class="text-sm mt-1">Days</span>
                    </span>
                    <span class="flex items-center">:</span>
                    <span class="flex flex-col items-center">
                        <span id="hours">00</span>
                        <span class="text-sm mt-1">Hours</span>
                    </span>
                    <span class="flex items-center">:</span>
                    <span class="flex flex-col items-center">
                        <span id="minutes">10</span>
                        <span class="text-sm mt-1">Minutes</span>
                    </span>
                    <span class="flex items-center">:</span>
                    <span class="flex flex-col items-center">
                        <span id="seconds">24</span>
                        <span class="text-sm mt-1">Seconds</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-2 px-8 lg:px-24">
        <div class="flex flex-col items-center lg:flex-row lg:space-x-5 justify-center">
            <h3 class="text-2xl lg:text-6xl uppercase font-bold">SALE OF THE YEAR</h3>
            <a href="/products" class="bg-blue-900 text-white px-4 py-2 mt-5 lg:mt-0 rounded-full shadow-md hover:bg-blue-800 transition duration-200">Shop Now</a>
        </div>

        <div class="section-product grid gap-7 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

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
</div>
