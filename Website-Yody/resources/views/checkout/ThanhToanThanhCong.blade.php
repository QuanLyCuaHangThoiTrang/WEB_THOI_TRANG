@php
    // Define translations for both languages
    $commonData = [
        'en' => [
            'noti' => 'Payment Success!',
            'click' => 'Click',
            'here' => 'here',
            'continue' => 'to continue shopping',
        ],
        'vi' => [
            'noti' => 'Thanh toán thành công!',
            'click' => 'Click',
            'here' => 'vào đây',
            'continue' => 'để tiếp tục mua hàng',
        ],
    ];
    // Get the current language code
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp
@extends('layouts.app')
@section('content')
    <div class="container mx-auto py-32 flex justify-center items-center min-h-screen">
        <section class="text-center">
            <div class="grid grid-flow-row">
                <img alt="Ảnh giỏ hàng trống" loading="lazy" width="500" height="500" decoding="async" data-nimg="1"
                    class="mx-auto object-cover"
                    src="https://m.yodycdn.com/web/prod/_next/static/media/cart-empty.250eba9c.svg"
                    style="color: transparent;">
                <div class="">
                    <p class="font-bold text-2xl">{{ $selectedData['noti'] }}</p>
                    <p><a href="{{ url("/{$locale}/products") }}">{{ $selectedData['click'] }} <span
                                class="text-blue-800 font-bold">{{ $selectedData['here'] }}</span>
                            {{ $selectedData['continue'] }}</a></p>
                </div>
            </div>
        </section>
    </div>
@endsection
