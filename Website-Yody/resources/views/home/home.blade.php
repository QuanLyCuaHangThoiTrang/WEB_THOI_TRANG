<!-- resources/views/homepage.blade.php -->
@extends('layouts.app')
@section('content')

<div class="font-old-standard">
    <div class="relative">
        @include('home.components.swiper')
    </div>
    <div class="relative">
      @include('home.components.section-product')
    </div>
    <div class="relative">
      @include('home.components.section-midbanner')
    </div>
    <div class="relative">
      @include('home.components.section-features')
    </div>
</div>

@endsection
