<div class="relative flex items-center max-w-[8rem] border rounded-2xl">
    <button type="button" class="decrement rounded-s-lg p-2 h-11 focus:outline-none" data-index="{{ $index }}">
        <x-icons.icon name="decrement"/>
    </button>
    @if (Auth::check())
        <input type="text" id="quantity-input-{{ $index }}" class="h-10 w-12 text-center text-sm py-2.5 text-black quantity-input" name="items[{{ $index }}][SoLuong]" value="{{ $chitiet->SoLuong }}" required data-index="{{ $index }}" readonly/>
    @else
        <input type="text" id="quantity-input-{{ $index }}" class="h-10 w-12 text-center text-sm py-2.5 text-black quantity-input" name="items[{{ $index }}][SoLuong]" value="{{ $item['SoLuong'] }}" required data-index="{{ $index }}" readonly/>
    @endif  
    <button type="button" class="increment rounded-e-lg p-2 h-11 focus:outline-none" data-index="{{ $index }}">
        <x-icons.icon name="increment"/>
    </button>
</div>
