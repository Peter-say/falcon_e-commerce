@extends('web.layouts.app')

@section('contents')

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="product-slider" id="galleryTop">
                        <div class="swiper-container theme-slider position-lg-absolute all-0"
                            data-swiper='{"autoHeight":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"thumb":{"spaceBetween":5,"slidesPerView":5,"loop":true,"freeMode":true,"grabCursor":true,"loopedSlides":5,"centeredSlides":true,"slideToClickedSlide":true,"watchSlidesVisibility":true,"watchSlidesProgress":true,"parent":"#galleryTop"},"slideToClickedSlide":true}'>
                            <div class="swiper-wrapper h-100">
                                @if (is_array(json_decode($product->images)) && count(json_decode($product->images)) === 1)
                                    @php
                                        $imagePath = json_decode($product->images);
                                    @endphp
                                    <div class="swiper-slide h-100"> <img class="rounded-1 object-fit-cover h-100 w-100"
                                            src="{{ asset('product/images/' . $imagePath) }}" alt="" /></div>
                                @elseif (is_array(json_decode($product->images)) && count(json_decode($product->images)) > 1)
                                    {{-- Display a collection of images --}}
                                    @foreach (json_decode($product->images) as $imagePath)
                                        <div class="swiper-slide h-100"> <img class="rounded-1 object-fit-cover h-100 w-100"
                                                src="{{ asset('product/images/' . $imagePath) }}" alt="" /></div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="swiper-nav">
                                <div class="swiper-button-next swiper-button-white"></div>
                                <div class="swiper-button-prev swiper-button-white"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h5>{{ $product->name }}</h5>
                    <a class="fs--1 mb-2 d-block" href="#!">{{ $product->category->name }}</a>
                    <div class="fs--2 mb-3 d-inline-block text-decoration-none"><span
                            class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span
                            class="fa fa-star text-warning"></span><span class="fa fa-star text-warning"></span><span
                            class="fa fa-star-half-alt text-warning star-icon"></span><span class="ms-1 text-600">(8)</span>
                    </div>
                    <p class="fs--1">{{ $product->meta_description }}</p>
                    <h4 class="d-flex align-items-center"><span
                            class="text-warning me-2">${{ $product->amount }}</span><span class="me-1 fs--1 text-500"><del
                                class="me-1">${{ $product->discount_price }}</del><strong>-{{ number_format($product->discount_percent) }}%</strong></span>
                    </h4>
                    <p class="fs--1 mb-1"> <span>Shipping Cost: </span><strong>$50</strong></p>
                    <p class="fs--1">Stock: <strong class="text-success">{{ $product->stock_status }}</strong></p>
                    <p class="fs--1 mb-3">Tags:
                        @foreach (explode(',', $product->meta_keyword) as $keyword)
                            <a class="ms-1" href="#!">{{ $keyword }},</a>
                        @endforeach
                    </p>

                    <div class="row">

                        @livewire('cart.add-to-cart', ['id' => $product->id])

                    </div>



                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="overflow-hidden mt-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active ps-0" id="description-tab" data-bs-toggle="tab"
                                    href="#tab-description" role="tab" aria-controls="tab-description"
                                    aria-selected="true">Description</a></li>
                            <li class="nav-item"><a class="nav-link px-2 px-md-3" id="specifications-tab"
                                    data-bs-toggle="tab" href="#tab-specifications" role="tab"
                                    aria-controls="tab-specifications" aria-selected="false">Specifications</a></li>
                            <li class="nav-item"><a class="nav-link px-2 px-md-3" id="reviews-tab" data-bs-toggle="tab"
                                    href="#tab-reviews" role="tab" aria-controls="tab-reviews"
                                    aria-selected="false">Reviews</a></li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tab-description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <div class="mt-3">
                                    {{ $product->description }}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-specifications" role="tabpanel"
                                aria-labelledby="specifications-tab">
                                <table class="table fs--1 mt-3">
                                    <tbody>
                                        @foreach ($product->specifications as $specification)
                                            <tr>
                                                <td class="bg-100" style="width: 30%;">{{ $specification->label }}
                                                </td>
                                                <td>{{ $specification->property }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="row mt-3">
                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                        <div class="mb-1"><span class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="ms-3 text-dark fw-semi-bold">Awesome support, great code
                                                😍</span>
                                        </div>
                                        <p class="fs--1 mb-2 text-600">By Drik Smith • October 14, 2019</p>
                                        <p class="mb-0">You shouldn't need to read a review to see how nice and
                                            polished
                                            this
                                            theme is. So I'll tell you something you won't find in the demo. After the
                                            download
                                            I had a technical question, emailed the team and got a response right from
                                            the
                                            team
                                            CEO with helpful advice.</p>
                                        <hr class="my-4" />
                                        <div class="mb-1"><span class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star text-warning fs--1"></span><span
                                                class="fa fa-star-half-alt text-warning star-icon fs--1"></span><span
                                                class="ms-3 text-dark fw-semi-bold">Outstanding Design, Awesome
                                                Support</span>
                                        </div>
                                        <p class="fs--1 mb-2 text-600">By Liane • December 14, 2019</p>
                                        <p class="mb-0">This really is an amazing template - from the style to the
                                            font -
                                            clean layout. SO worth the money! The demo pages show off what Bootstrap 4
                                            can
                                            impressively do. Great template!! Support response is FAST and the team is
                                            amazing -
                                            communication is important.</p>
                                    </div>
                                    <div class="col-lg-6 ps-lg-5">
                                        <form>
                                            <h5 class="mb-3">Write your Review</h5>
                                            <div class="mb-3"><label class="form-label">Ratting: </label>
                                                <div class="d-block" data-rater='{"starSize":32,"step":0.5}'></div>
                                            </div>
                                            <div class="mb-3"><label class="form-label"
                                                    for="formGroupNameInput">Name:</label><input class="form-control"
                                                    id="formGroupNameInput" type="text" /></div>
                                            <div class="mb-3"><label class="form-label"
                                                    for="formGroupEmailInput">Email:</label><input class="form-control"
                                                    id="formGroupEmailInput" type="email" />
                                            </div>
                                            <div class="mb-3"><label class="form-label"
                                                    for="formGrouptextareaInput">Review:</label>
                                                <textarea class="form-control" id="formGrouptextareaInput" rows="3"></textarea>
                                            </div><button class="btn btn-primary" type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2>Related Products</h2>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                @foreach ($related_products as $product)
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
                                <div><a class="btn btn-sm btn-falcon-default me-2" href="#!"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Wish List"><span
                                            class="far fa-heart"></span></a><a class="btn btn-sm btn-falcon-default"
                                        href="#!" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Add to Cart"><span class="fas fa-cart-plus"></span></a></div>
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
                    class="btn btn-sm btn-falcon-default me-2" href="#!"> <span
                        class="fas fa-ellipsis-h"></span></a><a class="btn btn-sm btn-falcon-default me-2"
                    href="#!">35</a><button class="btn btn-falcon-default btn-sm" type="button"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Next"><span class="fas fa-chevron-right">
                    </span></button></div>
        </div>
    </div>

@endsection
