<div class="p-6 px-32 pb-10 flex gap-10">
    <!-- Define reusable columns in the mega menu -->
    @foreach(['Category 1', 'Category 2', 'Category 3'] as $category)
        <div class="w-1/4 border-r-2">
            <h3 class="text-lg font-semibold mb-4">{{ $category }}</h3>
            <ul class="space-y-2">
                @for($i = 1; $i <= 3; $i++)
                    <li><a href="#" class="block text-base hover:bg-gray-100 py-1">Sub-item {{ $i }}</a></li>
                @endfor
            </ul>
        </div>
    @endforeach

    <!-- Image Column -->
    <div class="w-1/4">
        <img src="https://yody.vn/images/menu-desktop/menu_man.png" alt="Featured" class="w-full h-auto rounded-lg shadow-md">
    </div>
</div>
