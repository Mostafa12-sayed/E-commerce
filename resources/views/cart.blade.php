@extends('layouts.master')
@section('title', 'Cart')
@section('content')
  @php
  $cart_items = $cart->get();
  @endphp

  <div class="container mt-5 mb-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-10">
            <div class="p-2 text-center">
                <h4 class="font-weight-bold">Shopping cart</h4>
            </div>
            @if($cart_items->count()>0)

            <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
              <div class="mr-1">Image</div>
              <div class="d-flex flex-column align-items-center product-details"><span class="font-weight-bold">Product Name</span>
              </div>
              <div  class="mr-1">Quantity</div>
              <div class="mr-1">Price</div>
              <div class="mr-1">Total Price</div>
              <div class="d-flex align-items-center">
               Action
              </div>
          </div>
            @foreach ($cart_items as $item)
              <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
                  <div class="mr-1"><img class="rounded" src="{{asset('storage/' . $item->product->image)}}" width="70"></div>
                  <div class="d-flex flex-column align-items-center product-details"><span class="font-weight-bold">{{$item->product->name}}</span>
                  </div>
                  <div class="d-flex flex-row align-items-center qty gap-2 text-center">
                    <i class="fa fa-minus text-danger" onclick="updateQuantity('{{$item->product->id}}', 'decrease' , '{{$item->id}}')"></i>
                      <h5 class="text-grey mt-1 mr-1 ml-1" id="quantity-{{$item->id}}">{{$item->quantity}}</h5>
                      <i class="fa fa-plus text-success" onclick="updateQuantity('{{$item->product->id}}', 'increase' , '{{$item->id}}')"></i>
                    </div>
                  <div>
                      <h5 class="text-grey">${{$item->product->price}}</h5>
                  </div>
                  <div>
                    <h5 class="text-grey" id="total-price-product-{{$item->id}}">${{$item->product->price * $item->quantity}}</h5>
                </div>
                  <div class="d-flex align-items-center">
                    <a href="#" onclick="event.preventDefault(); document.querySelector('#delete-form-{{$item->id}}').submit();">
                      <i class="fa fa-trash mb-1 text-danger"></i>
                  </a>                    <form action="{{route('cart.destroy', $item->id)}}" id="delete-form-{{$item->id}}" method="POST">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
              </div>
            @endforeach
            <div class="d-flex flex-row align-items-center justify-content-between mt-3 p-2 bg-white rounded">
              <div class="mr-1 font-weight-bold">Total Price: ${{$cart->total()}}</div>
              <a class="btn btn-warning btn-block btn-lg ml-2 pay-button" href="{{route('checkout.create')}}" type="button">Checkout</a></div>
            @else
            <div class="d-flex flex-row justify-content-center align-items-center p-4 bg-white mt-4 px-3 rounded">
                <h4 style="color: rgb(179, 179, 179)">No Products in cart</h4>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
  function updateQuantity(id,action,item_id) { 
      let quantityElement = document.querySelector('#quantity-' + item_id);
      let currentQuantity = parseInt(quantityElement.textContent);
      let new_quantity = action === 'increase' ? currentQuantity + 1 : currentQuantity - 1;
      if (new_quantity < 1) {
          return;
      }
      quantityElement.textContent = new_quantity;
      let url = `/cart/${item_id}`;
      $.ajax({
          url: url,
          type: 'PUT',
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          data: {
              product_id: id,
              quantity: new_quantity
          },
          success: function(response) {
              if(response)
              {
                var cart =response[0];
                var quantity = cart.quantity;
                var price = cart.product.price;
                var total_price = price * quantity;
                document.getElementById('total-price-product-' + item_id).textContent = '$' + total_price.toFixed(1);
              }
          },
          error: function(error) {
              console.error('Error updating cart:', error);
          }
      });
  }
  </script>
  @endsection
