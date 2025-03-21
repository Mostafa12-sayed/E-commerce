
@extends('layouts.master')
@section('title', 'Checkout')
@section('content')
  @php
  $cart_items = $cart->get();
  @endphp

<style>
  .title-style{
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight: 700;
    font-size: 20px;
    color: hsl(52, 0%, 98%);
  }
  .title-quote{
    font-family: Georgia, 'Times New Roman', Times, serif;
    font-weight: 400;
    color: hsl(52, 0%, 98%);
  }
</style>
<div class="container py-5">
  <div class="row d-flex justify-content-center align-items-center">
    <div class="col">
      <div class="card my-4 shadow-3">
        <div class="row g-0">
          <div class="col-xl-12 ">
            <div class="card-body p-md-5 text-black">
              <h3 class="mb-4 text-uppercase">Delivery Info</h3>
              <form action="{{route('checkout.store')}}" method="post">
                @csrf
                <div class="col-md-12 mb-4">
                    <label class="form-label" for="form3Example1m" >Full name</label>
                    <input type="text" value="{{old('name')}}" name="name" id="form3Example1m" class="form-control form-control-lg"  required/>
                </div>
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example2">Email</label>
                  <input type="text" value="{{old('email')}}" name="email" id="form3Example2" class="form-control form-control-lg"  />
                </div>
                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example2">Phone number</label>
                  <input type="text" value="{{old('phone_number')}}" name="phone_number" id="form3Example2" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="form3Example8">Address</label>
                  <input type="text" value="{{old('street_addresses')}}"  name="street_addresses" id="form3Example8" class="form-control form-control-lg" required />
                </div>

                <label class="form-label" for="form3Example8">Payment Method</label>
                <div class=" col-md-12 mb-4 d-flex gap-5">
                  <div class=" mb-4">
                    <input type="radio" value="cash"  name="payment_method" id="payment_method_cash"   />
                    <label class="form-label" for="payment_method_cash">Cash</label>
                  </div>
                  <div class=" mb-4">
                    <input type="radio" value="card"  name="payment_method" id="payment_method_card"  />
                    <label class="form-label" for="payment_method_card">Card</label>
                  </div>
                </div>
                <div class="d-flex justify-content-end pt-3">
                  <button type="submit"  class="btn btn-success btn-lg ms-2"
                    style="background-color:hsl(210, 100%, 50%) ">Place Order</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
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
          return; // لا يمكن أن تكون الكمية أقل من 1
      }
  
      quantityElement.textContent = new_quantity;
  
      let url = `/cart/${item_id}`;
  
      $.ajax({
          url: url,
          type: 'PUT', // استخدام PUT لأنه تحديث للبيانات
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          data: {
              product_id: id,
              quantity: new_quantity
          },
          success: function(response) {
              // console.log('Cart updated:', response);
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
