<!-- Start testimonials Area
============================================= -->
<div class="testimonials-area bg-green2 default-padding bottom-less position-relative">
    <!-- Fixed Shape -->
    <div class="fixed-shape" style="background-image: url(assets/img/shape/10-red.png);"></div>
    <!-- End Fixed Shape -->
    <div class="container">
        <div class="testimonial-items">
            <div class="row align-center">
                <div class="col-lg-7 testimonials-content">
                    <div class="testimonials-carousel owl-carousel owl-theme">
                        @foreach ($reviews as $review)
                        <div class="item">
                            <div class="info">
                                <p>{{ $review->body }}</p>
                                <div class="provider">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/img/100x100.png') }}" alt="Author">
                                    </div>
                                    <div class="content">
                                        <strong>{{ $review->name }}</strong>
                                        @if ($review->position)
                                        <span>/ {{ $review->position }}</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-5 info">
                    <h2>{{ $reviewsText->getTranslatedAttribute('name') }}</h2>
                    <p>{{ $reviewsText->getTranslatedAttribute('description') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End testimonials Area -->
