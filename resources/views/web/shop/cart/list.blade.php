@extends('web.layouts.app')

@section('contents')

<div class="card">
    <div class="card-header">
      <div class="row justify-content-between">
        <div class="col-md-auto">
          <h5 class="mb-3 mb-md-0">Shopping Cart ({{$cartCount}} Items)</h5>
        </div>
        <div class="col-md-auto"><a class="btn btn-sm btn-outline-secondary border-300 me-2 shadow-none" href="/"> <span class="fas fa-chevron-left me-1" data-fa-transform="shrink-4"></span>Continue Shopping</a><a class="btn btn-sm btn-primary" href="checkout.html">Checkout</a></div>
      </div>
    </div>
    
    @livewire('cart.shopping-cart')

    <div class="card-footer bg-light d-flex justify-content-end">
      <form class="me-3">
        <div class="input-group input-group-sm"><input class="form-control" type="text" placeholder="Promocode" /><button class="btn btn-outline-secondary border-300 btn-sm shadow-none" type="submit">Apply</button></div>
      </form><a class="btn btn-sm btn-primary" href="checkout.html">Checkout</a>
    </div>
  </div>

@endsection