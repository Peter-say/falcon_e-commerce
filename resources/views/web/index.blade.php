@extends('web.layouts.app')

@section('contents')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row flex-between-center">
                <div class="col-sm-auto mb-2 mb-sm-0">
                    <h6 class="mb-0">Showing 1-24 of 205 Products</h6>
                </div>
                <div class="col-sm-auto">
                    <div class="row gx-2 align-items-center">
                        <div class="col-auto">
                            <form class="row gx-2">
                                <div class="col-auto"><small>Sort by:</small></div>
                                <div class="col-auto"> <select class="form-select form-select-sm" aria-label="Bulk actions">
                                        <option selected="">Best Match</option>
                                        <option value="Refund">Newest</option>
                                        <option value="Delete">Price</option>
                                    </select></div>
                            </form>
                        </div>
                        <div class="col-auto pe-0"> <a class="text-600 px-1" href="product-list.html"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Product List"><span
                                    class="fas fa-list-ul"></span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                @foreach ($products as $product)
                    <div class="mb-4 col-md-6 col-lg-4">
                        <div class="border rounded-1 h-100 d-flex flex-column justify-content-between pb-3">
                            <div class="overflow-hidden">
                                <div class="position-relative rounded-top overflow-hidden">
                                    <div class="swiper-container theme-slider"
                                        data-swiper='{"autoplay":true,"autoHeight":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"navigation":{"nextEl":".swiper-button-next","prevEl":".swiper-button-prev"}}'>
                                        <div class="swiper-wrapper">
                                            @forelse (json_decode($product->images) as $imagePath)
                                                <div class="swiper-slide">
                                                    <a class="d-block"
                                                        href="{{ route('shop.product.details', $product->slug) }}">
                                                        <img class="rounded-top img-fluid"
                                                            src="{{ asset('product/images/' . $imagePath) }}"
                                                            alt="product image" />
                                                    </a>
                                                </div>
                                            @empty
                                                {{-- Display a placeholder image or message when no images are available --}}
                                                <div class="swiper-slide">
                                                    <a class="d-block"
                                                        href="{{ route('shop.product.details', $product->slug) }}">
                                                        <img class="rounded-top img-fluid"
                                                            src="{{ asset('path/to/placeholder-image.jpg') }}"
                                                            alt="placeholder image" />
                                                    </a>
                                                </div>
                                            @endforelse
                                        </div>
                                        <div class="swiper-nav">
                                            <div class="swiper-button-next swiper-button-white"></div>
                                            <div class="swiper-button-prev swiper-button-white"></div>
                                        </div>
                                    </div>

                                    <span
                                        class="badge rounded-pill bg-success position-absolute mt-2 me-2 z-2 top-0 end-0">New</span>
                                </div>
                                <div class="p-3">
                                    <h5 class="fs-0"><a class="text-dark"
                                            href="{{ route('shop.product.details', $product->slug) }}">{{ $product->name }}
                                        </a></h5>
                                    <p class="fs--1 mb-3"><a class="text-500"
                                            href="#!">{{ $product->category->name }}</a>
                                    </p>
                                    <h5 class="fs-md-2 text-warning mb-0 d-flex align-items-center mb-3">
                                        ${{ $product->amount }}</h5>
                                    <p class="fs--1 mb-1">Shipping Cost: <strong>$65</strong></p>
                                    <p class="fs--1 mb-1">Stock: <strong
                                            class="text-danger">{{ $product->stock_status }}</strong></p>
                                </div>
                            </div>
                            <div class="d-flex flex-between-center px-3">
                                <div><span class="fa fa-star text-warning"></span><span
                                        class="fa fa-star text-warning"></span><span
                                        class="fa fa-star text-warning"></span><span
                                        class="fa fa-star text-warning"></span><span
                                        class="fa fa-star-half-alt text-warning star-icon"></span><span
                                        class="ms-1">(20)</span></div>
                                <div><a class="btn btn-sm btn-falcon-default me-2" href="#!" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Add to Wish List"><span
                                            class="far fa-heart"></span></a>
                                    @livewire('cart.general-cart')
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer bg-light d-flex justify-content-center">
            <div><button class="btn btn-falcon-default btn-sm me-2" type="button" disabled="disabled"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Prev"><span
                        class="fas fa-chevron-left"></span></button><a
                    class="btn btn-sm btn-falcon-default text-primary me-2" href="#!">1</a><a
                    class="btn btn-sm btn-falcon-default me-2" href="#!">2</a><a
                    class="btn btn-sm btn-falcon-default me-2" href="#!"> <span class="fas fa-ellipsis-h"></span></a><a
                    class="btn btn-sm btn-falcon-default me-2" href="#!">35</a><button
                    class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Next"><span class="fas fa-chevron-right">
                    </span></button></div>
        </div>
    </div>
@endsection
