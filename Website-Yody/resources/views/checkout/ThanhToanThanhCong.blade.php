@extends('layouts.app')

@section('content')
<div class="container mx-auto py-32 flex justify-center items-center min-h-screen">
    <section class="text-center">
        <div class="grid grid-flow-row">
            <img alt="Ảnh giỏ hàng trống" loading="lazy" width="500" height="500" decoding="async" data-nimg="1" class="mx-auto object-cover" src="https://m.yodycdn.com/web/prod/_next/static/media/cart-empty.250eba9c.svg" style="color: transparent;">  
            <div class="">
                <p class="font-bold text-2xl">THANH TOÁN THÀNH CÔNG</p>
                <p><a href="{{ route('products.index') }}">Bấm <span class="text-blue-800 font-bold">vào đây</span> để tiếp tục mua hàng</a></p>
            </div>  
        </div>
    </section>
</div>
@endsection