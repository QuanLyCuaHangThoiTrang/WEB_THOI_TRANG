@php
    // Define translations for both languages
    $commonData = [
        'en' => [
            'account' => 'Account',
            'address' => 'Address',
            'coupon' => 'Voucher',
            'order' => 'Order',
        ],
        'vi' => [
            'account' => 'Tài khoản',
            'address' => 'Địa chỉ',
            'coupon' => 'Phiếu giảm giá',
            'order' => 'Đơn hàng',
        ],
    ];
    // Get the current language code
    $locale = request()->segment(1, 'vi'); // Default to 'vi' if no language code in URL

    // Get the translation data for the selected language
    $selectedData = $commonData[$locale] ?? $commonData['vi']; // Fall back to 'vi' if not found
@endphp

<form class="hidden lg:block">
    <div>
        <ul role="list" class="space-y-4 border-gray-200 pb-6 text-xl font-medium text-gray-900">
            <li><a href="{{ url("/{$locale}/account/{$khachhang->MaKH}") }}">{{ $selectedData['account'] }}</a></li>
            <li><a href="{{ url("/{$locale}/addresses/{$khachhang->MaKH}") }}">{{ $selectedData['address'] }}</a></li>
            <li><a href="{{ url("/{$locale}/vouchers/{$khachhang->MaKH}") }}">{{ $selectedData['coupon'] }}</a></li>
            <li><a href="{{ url("/{$locale}/order/{$khachhang->MaKH}") }}">{{ $selectedData['order'] }}</a></li>
        </ul>
    </div>
</form>
