<!-- resources/views/homepage.blade.php -->
@extends('layouts.app')
@section('content')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('button[aria-expanded]');

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const expanded = button.getAttribute('aria-expanded') === 'true';
        const sectionId = button.getAttribute('aria-controls');
        const section = document.getElementById(sectionId);
        const expandIcon = button.querySelector('[id^="expand-icon-"]');
        const collapseIcon = button.querySelector('[id^="collapse-icon-"]');

        button.setAttribute('aria-expanded', !expanded);
        section.classList.toggle('hidden');
        if (expandIcon) expandIcon.classList.toggle('hidden', !expanded);
        if (collapseIcon) collapseIcon.classList.toggle('hidden', expanded);
      });
    });

    // Dropdown menu functionality
    const menuButton = document.getElementById('menu-button');
    const dropdownMenu = document.getElementById('dropdown-menu');
    
    if (menuButton && dropdownMenu) {
      menuButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
      });

      // Close dropdown when clicking outside of it
      document.addEventListener('click', (event) => {
        if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
          dropdownMenu.classList.add('hidden');
        }
      });
    }
  });
</script>

@include('products.offcanvas')
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-4">
      <div class="flex items-baseline justify-between border-b border-gray-200 pt-12">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900">New Arrivals</h1>
        <div class="flex items-center p-6">
    <!-- Dropdown menu for sorting -->
    <div class="relative inline-block text-left">
      <div>
        <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" id="menu-button" aria-expanded="false" aria-haspopup="true">
          Sort
          <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>

      <!-- Dropdown menu, show/hide based on menu state -->
      <div class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="py-1" role="none">
          <a href="#" class="block px-4 py-2 text-sm font-medium text-gray-900" role="menuitem" tabindex="-1" id="menu-item-0">Most Popular</a>
          <a href="#" class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1" id="menu-item-1">Best Rating</a>
          <a href="#" class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1" id="menu-item-2">Newest</a>
          <a href="#" class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1" id="menu-item-3">Price: Low to High</a>
          <a href="#" class="block px-4 py-2 text-sm text-gray-500" role="menuitem" tabindex="-1" id="menu-item-4">Price: High to Low</a>
        </div>
      </div>
    </div>
    <!-- Filters button -->
        <button type="button" id="menu-toggle" name="menu-toggle" class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden">
          <span class="sr-only">Filters</span>
          <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>

      <section aria-labelledby="products-heading" class="pb-24 pt-6">

        <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
       <!-- Filters -->
         @include('products.filter')

         <div class="col-span-3">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
          @foreach ($chiTietSanPhams as $chiTietSanPham)  
            <div class="group relative cursor-pointer">
                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                    <img src="{{ asset('images/products/' . $chiTietSanPham->HinhAnh) }}" alt="Product Image" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                </div>
                <div class="mt-4 pb-3">
                    <h3 class="text-base">{{ $chiTietSanPham->SanPham->TenSP }}</h3>
                    <!-- Sử dụng flex để căn chỉnh giá và nút chi tiết -->
                    <div class="flex justify-between items-center mt-2">
                        <h3 class="font-semibold">{{ $chiTietSanPham->SanPham->GiaBan }}VND</h3>
                        <!-- Nút Xem Chi Tiết -->
                        <a href="{{ url('/product_detail/' . $chiTietSanPham->MaSP) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            Chi Tiết
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
      </section>
    </main>


    </div>
</div>
@endsection