<div class="flex flex-col bg-gray-50 px-7 gap-4 p-6 mb-6">
    <div class="border-b">
        <h3 class="text-3xl font-semibold text-gray-900 mb-4">Vouchers</h3>
    </div>
    <ul role="list" class="space-y-4">
        @foreach($vouchers as $voucher)
            <li class="p-4 border rounded-md bg-white">
                <p class="text-gray-800">Voucher Code: {{ $voucher->code }}</p>
                <p class="text-gray-600">Expiry Date: {{ $voucher->expiry }}</p>
                <p class="text-green-600">Discount: {{ $voucher->discount }}</p>
            </li>
        @endforeach
    </ul>
</div>
