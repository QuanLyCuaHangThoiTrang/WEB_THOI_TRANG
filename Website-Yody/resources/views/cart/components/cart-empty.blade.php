@php
    // Define translations for both languages
    $commonData = [
        'en' => [
            'cart' => 'SHOPPING CART',
            'no_cart' => 'You have no items.',
        ],
        'vi' => [
            'cart' => 'GIỎ HÀNG',
            'no_cart' => 'Bạn chưa có sản phẩm nào trong giỏ hàng của bạn.',
        ],
    ];
    // Get the current language code
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp
<section class="w-full justify-center top-20 scrollbar-hidden h-full text-center">
    <div class="flex flex-col">
        <img alt="Ảnh giỏ hàng trống" loading="lazy" width="500" height="500" decoding="async" data-nimg="1"
            class=" mx-auto object-cover" src="https://m.yodycdn.com/web/prod/_next/static/media/cart-empty.250eba9c.svg"
            style="color: transparent;">
        <div class="">
            <p class="font-bold text-2xl">{{ $selectedData['cart'] }}</p>
            <p>{{ $selectedData['no_cart'] }}</p>
        </div>
    </div>
</section>
