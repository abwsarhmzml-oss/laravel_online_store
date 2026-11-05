<!--
 Kids page
 -->

@extends('layout.app')

@section('hello')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/css2/woman.css') }}">

    <title>Kids</title>
</head>
<body>
    <header>
        <div class="main_img">
            <img src="{{ asset('images/Kids_img/images (4).jpeg') }}" alt="modern sunglasses" class="banner-img">

            <div class="banner-content">
                <p class="banner-subtitle">Trending accessories</p>
                <h2 class="banner-title">Modern sunglasses</h2>
                <p class="banner-text">
                    starting at &dollar; <b>15</b>.00
                </p>

                <a href="#" class="banner-btn">Shop now</a>
            </div>
        </div>
    </header>

    <main>
        <div class="products-grid">
            @foreach ($prodect as $products)
                <div class="product-card">
                    <div class="product-img-container">
                        <img src="{{ asset('storage/' . $products->image) }}" alt="Modern sunglasses" class="product-img">
                        <span class="product-badge">new</span>
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">{{ $products->name }}</h3>
                        <p class="product-description">{{ $products->description }}</p>
                        <div class="product-footer">
                            <span class="product-price">{{ $products->price }}</span>
                           @if(auth()->check() && auth()->user()->role =='admain')
                            <form action="{{route('admain.destroy', $products->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="product-btn">Delete</button>
                            </form>
                          @endif

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</body>
</html>
@endsection
