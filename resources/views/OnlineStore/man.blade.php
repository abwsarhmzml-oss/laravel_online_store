<!--
 man page
 -->



@extends('layout.app')

@section('hello')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="{{ asset('css/css2/woman.css') }}">

    <title>man </title>
</head>
<body>
        <header>

          <div class="main_img">

            <img src="images/man_img/360_F_111678258_nOKyrp5tbacXVxAHLTVaNF1RJFJrlT8O.jpg" alt="modern sunglasses" class="banner-img">

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

          @foreach($prodect as $products)
<div class="products-grid">

    <!-- كارت المنتج الأول -->
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
                <a href="#" class="product-btn">أضف للسلة</a>
            </div>
        </div>
    </div>
</div>

@endforeach




          </main>

</body>
</html>
@endsection
