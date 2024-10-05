<!-- resources/views/components/notification.blade.php -->
@if(session('success'))
    <div class="notification absolute z-30 top-24 right-10 bg-green-400 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="notification absolute z-30 top-24 right-10 bg-red-400 text-white p-4 rounded-md mb-4 shadow-md transition-opacity duration-500">
        {{ session('error') }}
    </div>
@endif
