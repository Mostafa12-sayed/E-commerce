@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-danger text-white">Payment Failed</div>

                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fa fa-times-circle text-danger" style="font-size: 64px;"></i>
                    </div>
                    
                    <h2>Payment Failed</h2>
                    <p>Unfortunately, your payment could not be processed.</p>
                    <p>Please try again or contact customer support if the problem persists.</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                        <a href="{{ route('cart.index') }}" class="btn btn-secondary">Return to Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection