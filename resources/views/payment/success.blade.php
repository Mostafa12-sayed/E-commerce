@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5 ">
                <div class="card-header bg-success text-white">Payment Successful</div>

                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fa fa-check-circle text-success" style="font-size: 64px;"></i>
                    </div>
                    
                    <h2>Thank You!</h2>
                    <p>Your payment has been processed successfully.</p>
                    
                    @if(isset($order))
                    <div class="mt-4">
                        <h4>Order #{{ $order->id }}</h4>
                        <p>Total: {{ number_format($order->total, 2) }} EGP</p>
                    </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                        @if(isset($order))
                        {{-- <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">View Order Details</a> --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection