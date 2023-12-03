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

    </div>

@endsection