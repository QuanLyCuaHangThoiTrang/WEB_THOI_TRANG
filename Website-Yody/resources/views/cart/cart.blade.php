@extends('layouts.app')

@section('content')
<div class="bg-gray-100 px-10 pb-10 min-h-screen">
    <section class="container mt-20 mx-auto py-2 lg:py-4 bg-gray-100">
       @include('cart.components.cart-list')
    </section>
</div>
    @section('scripts')
    <script>
        document.querySelectorAll('.increment').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.dataset.index;
                const input = document.getElementById(`quantity-input-${index}`);
                let value = parseInt(input.value);
                if (!isNaN(value)) {
                    value++;
                    input.value = value;
                }
            });
        });

        document.querySelectorAll('.decrement').forEach(button => {
            button.addEventListener('click', () => {
                const index = button.dataset.index;
                const input = document.getElementById(`quantity-input-${index}`);
                let value = parseInt(input.value);
                if (!isNaN(value) && value > 1) {
                    value--;
                    input.value = value;
                }
            });
        });
    </script>
    @endsection
@endsection
