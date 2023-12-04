<div class="card-body p-0">
    <div class="row gx-card mx-0 bg-200 text-900 fs--1 fw-semi-bold">
        <div class="col-9 col-md-8 py-2">Name</div>
        <div class="col-3 col-md-4">
            <div class="row">
                <div class="col-md-8 py-2 d-none d-md-block text-center">Quantity</div>
                <div class="col-12 col-md-4 text-end py-2">Price</div>
            </div>
        </div>
    </div>
    @include('notifications.pop-up')
    @if (count($cartItems) > 0)
        @foreach ($cartItems as $item => $cartItem)
            <div class="row gx-card mx-0 align-items-center border-bottom border-200">
                <div class="col-8 py-3">
                    <div class="d-flex align-items-center"><a href="product/product-details.html">

                            <img class="img-fluid rounded-1 me-3 d-none d-md-block"
                                src="{{ asset('product/images/' . json_decode($cartItem->product->images)[0]) }}" alt=""
                                width="60" /> </a>


                        <div class="flex-1">
                            <h5 class="fs-0"><a class="text-900"
                                    href="product/product-details.html">{{ $cartItem->product->name }}</a></h5>
                            <div class="fs--2 fs-md--1"><a class="text-danger" href="#!" wire:click="removeFromCart({{$item}})">Remove</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-4 py-3">
                    <div class="row align-items-center">
                        <div class="col-md-8 d-flex justify-content-end justify-content-md-center order-1 order-md-0">
                            <div>
                                <div class="input-group input-group-sm flex-nowrap" data-quantity="data-quantity">
                                    <button  wire:click="decrementQuantity({{ $item }})" class="btn btn-sm btn-outline-secondary border-300 px-2 shadow-none"
                                        data-type="minus">-</button><input
                                        class="form-control text-center px-2 input-spin-none" type="number"
                                        min="1"  value="{{ $cartItem->quantity }}" aria-label="Amount (to the nearest dollar)"
                                        style="width: 50px" /><button  wire:click="incrementQuantity({{ $item }})"
                                        class="btn btn-sm btn-outline-secondary border-300 px-2 shadow-none"
                                        data-type="plus">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end ps-0 order-0 order-md-1 mb-2 mb-md-0 text-600">
                           ${{ $cartItem->price * $cartItem->quantity }}</div>
                    </div>
                </div>
            </div>
        @endforeach


        <div class="row fw-bold gx-card mx-0">
            <div class="col-9 col-md-8 py-2 text-end text-900">Total</div>
            <div class="col px-0">
                <div class="row gx-card mx-0">
                    <div class="col-md-8 py-2 d-none d-md-block text-center">{{count($cartItems)}} (items)</div>
                    <div class="col-12 col-md-4 text-end py-2">${{$totalPrice}}</div>
                </div>
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center mt-5 mb-5">
            <h4> No Items In The Cart Yet</h4>
        </div>
    @endif
</div>
