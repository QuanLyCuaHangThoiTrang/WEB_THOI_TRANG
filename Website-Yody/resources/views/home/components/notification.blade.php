<div class="fixed bottom-24 right-[35px] z-50">
    <button onclick="openModal()"
        class="bg-indigo-600 text-white p-3 rounded-full shadow-lg hover:scale-110 transition duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path
                d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z" />
        </svg>
    </button>
</div>

<!-- Modal Notification -->
<div id="notificationModal" class="fixed top-1/4 right-0 z-50 mr-5 hidden">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
            &times;
        </button>
        <h2 class="text-2xl font-bold mb-4">Thông báo</h2>
        @foreach ($KhuyenMais as $KhuyenMai)
            <p>{{ $KhuyenMai->TenKM }}</p>
        @endforeach
    </div>
</div>

<script>
    let closeModalTimeout;

    function openModal() {
        const modal = document.getElementById('notificationModal');
        modal.classList.remove('hidden');
        closeModalTimeout = setTimeout(closeModal, 10000);
    }

    function closeModal() {
        const modal = document.getElementById('notificationModal');
        modal.classList.add('hidden');
        clearTimeout(closeModalTimeout);
    }
    window.onclick = function(event) {
        const modal = document.getElementById('notificationModal');
        if (event.target === modal) {
            closeModal();
        }
    };
</script>
