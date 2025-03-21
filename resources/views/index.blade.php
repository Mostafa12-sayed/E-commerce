@extends('layouts.master')
@section('title', 'Home')
@section('content')
    <div class="container mt-5">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="row col-md-8">
          <h2 class="mb-4 title">Products</h2>
          @if($products->count() == 0)
          <div class="alert alert-warning text-center">
            No products found.
          </div>
          @else
          @foreach($products as $product)
          <div class="col-md-4 product mb-4" id="item_1">
            <div
              class="d.flex flex-column justify-content-center align-items-center"
            >
              <img
                src="{{asset('storage/'.$product->image)}}"
                alt="baklava"
                id="product-image-1"
              />
              <div id="btn-add-to-cart-1">
                <form method="post" action="{{route('cart.store')}}">
                  @csrf
                  <input name="product_id" type="hidden" value="{{$product->id}}">
                  <input name="quantity" type="hidden" value="1">
          
                <button
                  class="btn btn-primary overlay-add-to-cart add-cart"
                  type="submit"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="20"
                    fill="none"
                    viewBox="0 0 21 20"
                  >
                    <g fill="#C73B0F" clip-path="url(#a)">
                      <path
                        d="M6.583 18.75a1.25 1.25 0 1 0 0-2.5 1.25 1.25 0 0 0 0 2.5ZM15.334 18.75a1.25 1.25 0 1 0 0-2.5 1.25 1.25 0 0 0 0 2.5ZM3.446 1.752a.625.625 0 0 0-.613-.502h-2.5V2.5h1.988l2.4 11.998a.625.625 0 0 0 .612.502h11.25v-1.25H5.847l-.5-2.5h11.238a.625.625 0 0 0 .61-.49l1.417-6.385h-1.28L16.083 10H5.096l-1.65-8.248Z"
                      />
                      <path
                        d="M11.584 3.75v-2.5h-1.25v2.5h-2.5V5h2.5v2.5h1.25V5h2.5V3.75h-2.5Z"
                      />
                    </g>
                    <defs>
                      <clipPath id="a">
                        <path fill="#fff" d="M.333 0h20v20h-20z" />
                      </clipPath>
                    </defs>
                  </svg>

                  Add to cart
                </button>
                </form>
              </div>
            </div>

            <span class="name" id="item_name_1">{{$product->name}}</span>
            <p class="description">{{$product->description}}</p>
            <span class="price" id="item_price_1">${{$product->price}}</span>
          </div>
          @endforeach
          @endif
    
        </div>
        @php
          $cart_items = $cart->get();
        @endphp
        <div class="col-md-4 mt-0 mb-4">
          <div class="right-sidebar bg-light">
            <h2 class="cart">Your Cart(<span id="cart-count">{{count($cart_items)}}</span>)</h2>
            <div class="cart-empty" id="cart-empty">
              <img src="./Images/illustration-empty-cart.svg" alt="baklava" />
              <p class="name">Your added items will appear here</p>
            </div>
            <div id="cart-items">
              @if(count($cart_items) > 0)
              @foreach ( $cart_items as $cart_item )
                
              <div class="col-10">
                       <div class="d-flex flex-column">
                         <h3 class="text-start name-item">{{$cart_item->product->name}}</h3>
                         <div
                           class="d.flex justify-content-between text-start mt-2 align-items-center"
                         >
                           <span class="counter">{{$cart_item->quantity}}x</span>
                           <span class="ms-4">@</span>
                           <span class="price">{{$cart_item->product->price}}</span>
                           <span class="total-price-item ms-2">${{$cart_item->quantity * $cart_item->product->price}}</span>
                       </div>
                       </div>
                    </div>
              @endforeach
           
                </div>
                <div class="order-summary mt-2" id="order-summary">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="total-price">Order Total</span>
                    <span class="total-price-value" id="total-price-value"
                      >${{$cart->total()}}</span
                    >
                  </div>
                  <a href="{{route('checkout.create')}}" class="btn w-100 confirm-order mt-2" id="confirm-order">
                    Confirm Order
                  </a>
                @else
                 
                  <p id="carbon" class="mt-3 mb-3 text-center p-4">
                     <strong class="p-4">Your Cart is Empty </strong>
                  </p>
          
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>




@endsection