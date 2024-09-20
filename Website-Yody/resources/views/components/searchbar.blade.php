<div id="search-modal" class="fixed inset-0 z-50 hidden bg-white transition-opacity duration-300 ease-in-out opacity-0">
    <button id="close-search-modal" class="absolute top-4 right-4 p-2 text-gray-600 hover:text-gray-900">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="p-4">
        <form action="{{ url('/search') }}" method="GET" class="flex flex-col items-center">
            <input 
                type="search" 
                name="query" 
                class="w-full px-4 py-2 mb-4 text-sm border border-gray-300 rounded-3xl focus:outline-none focus:ring-blue-500" 
                placeholder="Tìm kiếm sản phẩm..."
            />
        </form>
    </div>
</div>

<script>
    // JavaScript để mở và đóng modal tìm kiếm trên thiết bị nhỏ
   document.getElementById('search-toggle').addEventListener('click', () => {
    const modal = document.getElementById('search-modal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
    }, 10); // Thời gian nhỏ để đảm bảo lớp opacity-0 được áp dụng trước khi bắt đầu transition
});

document.getElementById('close-search-modal').addEventListener('click', () => {
    const modal = document.getElementById('search-modal');
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300); // Thời gian trùng khớp với thời gian transition opacity
});
</script>