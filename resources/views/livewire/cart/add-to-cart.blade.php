<div class="row">

    @include('notifications.pop-up')

    <div class="col-auto pe-0">
        <div class="input-group input-group-sm" data-quantity="data-quantity">
            <button wire:click="decrementQuantity()" class="btn btn-sm btn-outline-secondary border border-300"
                data-field="input-quantity" data-type="minus">-</button>
            <input wire:model="quantity" class="form-control text-center input-quantity input-spin-none" type="number"
                min="0" value="0" aria-label="Amount (to the nearest dollar)" style="max-width: 50px" />
            <button wire:click="incrementQuantity()" class="btn btn-sm btn-outline-secondary border border-300"
                data-field="input-quantity" data-type="plus">+</button>
        </div>
        <input type="hidden" name="product_id" value="{{ $product->id }}">
    </div>

    <div class="col-auto px-2 px-md-3">
        <a wire:click.prevent="addToCart({{ $product->id }})" class="btn btn-sm btn-primary" href="#!">
            <span class="fas fa-cart-plus me-sm-2"></span>
            <span class="d-none d-sm-inline-block">Add To Cart</span>
        </a>
    </div>


    <div class="col-auto px-0"><a class="btn btn-sm btn-outline-danger border border-300" href="#!"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Wish List"><span
                class="far fa-heart me-1"></span>282</a>

    </div>

    @error('quantity')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
