<!-- Start testimonials Area
============================================= -->
<div class="testimonials-area bg-green2 default-padding bottom-less position-relative">
    <!-- Fixed Shape -->
    <div class="fixed-shape" style="background-image: url({{ asset('assets/img/shape/10-primary.png') }});"></div>
    <!-- End Fixed Shape -->
    <div class="container">

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h2>{{ $reviewsText->getTranslatedAttribute('name') }}</h2>
                    {{-- <p>{{ $servicesPage->getTranslatedAttribute('description') }}</p> --}}
                    {{-- <div class="divider"></div> --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="testimonial-items">
                    <div class="testimonials-content">
                        <div class="testimonials-carousel owl-carousel owl-theme">
                            @foreach ($reviews as $review)
                            <div class="item">
                                <div class="info">
                                    <p class="mb-2">{{ $review->getTranslatedAttribute('body') }}</p>
                                    {{-- <div>
                                        @include('partials.stars', ['rating' => $review->rating])
                                    </div> --}}
                                    <div class="provider">
                                        <div class="thumb">
                                            <img src="{{ $review->avatar_micro_img }}" alt="Author">
                                        </div>
                                        <div class="content">
                                            <div class="lh-125">
                                                <strong>{{ $review->getTranslatedAttribute('name') }}</strong>
                                            </div>
                                            @if ($review->getTranslatedAttribute('position'))
                                            <div class="lh-125">
                                                <span>{{ $review->getTranslatedAttribute('position') }}</span>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="certificates-carousel owl-carousel owl-theme h-100 py-5">
                    @foreach ($certificates as $certificate)
                        <div class="review-certificate-img">
                            <a href="{{ $certificate->img }}" data-fancybox="reviews" class="d-block">
                                <img src="{{ $certificate->small_img }}" alt="" class="img-fluid">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End testimonials Area -->
