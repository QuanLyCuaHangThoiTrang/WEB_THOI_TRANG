<!-- resources/views/homepage.blade.php -->
@extends('layouts.app')
@section('content')
    <div class="">
        <div class="relative font-old-standard">
            @include('home.components.swiper')
        </div>
        <div class="relative font-plus-jakara">
            @include('home.components.sale-section')
        </div>
        <div class="relative">
            @include('home.components.midbanner-section')
        </div>
        <div>
            @include('home.components.collection-section')
        </div>
        <div class="relative font-plus-jakara">
            @include('home.components.feature-section')
        </div>

    </div>
@endsection
