@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))
@section('body_class', 'home-page')

@section('content')

@if (session()->has('alert') || session()->has('success') || session()->has('status') || session()->has('error') || session()->has('message'))
<div class="content-block">
    @include('partials.alerts')
</div>
@endif

<!-- Start Banner
    ============================================= -->
<div class="banner-area inc-video video-bg-live bg-cover" style="background-image: url(assets/img/2440x1578.png);">
    <div class="player" data-property="{videoURL:'gOqlwlQjVis',containment:'.video-bg-live', showControls:false, autoPlay:true, zoom:0, loop:true, mute:true, startAt:3, opacity:1, quality:'default'}"></div>

    <div id="bootcarousel" class="carousel text-light slide animate_text" data-ride="carousel">

        <!-- Indicators for slides -->
        <div class="carousel-indicator">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="carousel-indicators right">
                            <li data-target="#bootcarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#bootcarousel" data-slide-to="1"></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="box-table shadow dark">
                    <div class="box-cell">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-4">
                                    <div class="content">
                                        <h4 data-animation="animated zoomInRight">Include more sales</h4>
                                        <h2 data-animation="animated slideInRight">We Provide Business Planing <span>Solution</span></h2>
                                        <a data-animation="animated zoomInUp" class="btn btn-theme effect btn-md" href="#">Discover More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="box-table shadow dark">
                    <div class="box-cell">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 offset-lg-4">
                                    <div class="content">
                                        <h4 data-animation="animated zoomInRight">More convenient</h4>
                                        <h2 data-animation="animated slideInUp">Find Value And Build Some <span>Confidence</span></h2>
                                        <a data-animation="animated zoomInUp" class="btn btn-theme effect btn-md" href="#">Discover More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Wrapper for slides -->

    </div>
</div>
<!-- End Banner -->

<!-- Star Services Area
============================================= -->
<div class="default-services-area default-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h4>Our Services</h4>
                    <h2>What We Bring To You</h2>
                    <div class="devider"></div>
                    <p>
                        While mirth large of on front. Ye he greater related adapted proceed entered an. Through it examine express promise no. Past add size game cold girl off how old
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="services-items">
            <div class="row">
                <!-- Single Item -->
                <div class="col-lg-4 col-md-6 single-item">
                    <div class="item">
                        <div class="info">
                            <i class="flaticon-money"></i>
                            <h4><a href="#">Financial Planning</a></h4>
                            <p>
                                Prevailed always tolerably discourse and loser assurance creatively coin applauded more uncommonly. Him everything trouble
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-lg-4 col-md-6 single-item">
                    <div class="item">
                        <div class="info">
                            <i class="flaticon-budget"></i>
                            <h4><a href="#">Investment Planning</a></h4>
                            <p>
                                Prevailed always tolerably discourse and loser assurance creatively coin applauded more uncommonly. Him everything trouble
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-lg-4 col-md-6 single-item">
                    <div class="item">
                        <div class="info">
                            <i class="flaticon-money-1"></i>
                            <h4><a href="#">Mutual Funds</a></h4>
                            <p>
                                Prevailed always tolerably discourse and loser assurance creatively coin applauded more uncommonly. Him everything trouble
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-lg-4 col-md-6 single-item">
                    <div class="item">
                        <div class="info">
                            <i class="flaticon-funds"></i>
                            <h4><a href="#">Saving & Investments</a></h4>
                            <p>
                                Prevailed always tolerably discourse and loser assurance creatively coin applauded more uncommonly. Him everything trouble
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-lg-4 col-md-6 single-item">
                    <div class="item">
                        <div class="info">
                            <i class="flaticon-analysis"></i>
                            <h4><a href="#">Markets Research</a></h4>
                            <p>
                                Prevailed always tolerably discourse and loser assurance creatively coin applauded more uncommonly. Him everything trouble
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-lg-4 col-md-6 single-item">
                    <div class="item">
                        <div class="info">
                            <i class="flaticon-analytics-1"></i>
                            <h4><a href="#">Report Analysis</a></h4>
                            <p>
                                Prevailed always tolerably discourse and loser assurance creatively coin applauded more uncommonly. Him everything trouble
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
            </div>
        </div>
    </div>
</div>
<!-- End Services Area -->

<!-- Star About Area
============================================= -->
<div class="about-area bg-dark overflow-hidden text-light relative">
    <!-- Fixed Shape -->
    <div class="fixed-shape" style="background-image: url(assets/img/shape/8.png);"></div>
    <!-- End Fixed Shape -->
    <div class="container">
        <div class="about-items">
            <div class="row">
                <div class="col-lg-6 thumb order-lg-last" style="background-image: url(assets/img/2440x1578.png);">
                    <div class="successr-ate">
                        <div class="icon">
                            <i class="flaticon-target"></i>
                        </div>
                        <div class="content">
                            <h2>98%</h2>
                            <span>Success Rate</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 info">
                    <h4>Who we are</h4>
                    <h2>We Combine Technology <br> with Business Ideas</h2>
                    <p>
                        Friendly bachelor entrance to on by. Extremity as if breakfast agreement. Off now mistress provided out horrible opinions. Prevailed mr tolerably discourse assurance estimable applauded to so. Him everything melancholy uncommonly but solicitude inhabiting projection.
                    </p>
                    <ul>
                        <li>
                            <h5>First Working Prosses</h5>
                            <p>
                                Contrasted sufficient to unpleasant in in insensible favourable.
                            </p>
                        </li>
                        <li>
                            <h5>24/7 Live Support</h5>
                            <p>
                                Contrasted sufficient to unpleasant in in insensible favourable.
                            </p>
                        </li>
                    </ul>
                    <a class="btn btn-light effect btn-md" href="#">Discover More</a>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End About Area -->

<!-- Start Expertise Area
============================================= -->
<div class="expertise-area default-padding">
    <div class="container">
        <!-- Item Heading -->
        <div class="item-heading">
            <div class="row">
                <div class="col-lg-6 info">
                    <h4>Our expertise</h4>
                    <h2>We design brand, digital experience that engage the right customers</h2>
                </div>
                <div class="col-lg-6 right-info">
                    <div class="skill-items">
                        <!-- Progress Bar Start -->
                        <div class="progress-box">
                            <h5>Marketing</h5>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" data-width="88">
                                    <span>88%</span>
                                </div>
                            </div>
                        </div>
                        <div class="progress-box">
                            <h5>Social Assistant</h5>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" data-width="95">
                                    <span>95%</span>
                                </div>
                            </div>
                        </div>
                        <div class="progress-box">
                            <h5>Consulting</h5>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" data-width="70">
                                    <span>70%</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Progressbar -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Item Heading -->

        <!-- Expertise Content -->
        <div class="expertise-content text-light" style="background-image: url(assets/img/2440x1578.png);">
            <div class="row">
                <!-- Single Item -->
                <div class="col-lg-4 single-item">
                    <div class="item">
                        <div class="content">
                            <h4>Finance Restructuring</h4>
                            <p>
                                    Prevailed mr tolerably discourse assurance estimable more power.
                            </p>
                        </div>
                        <a class="btn btn-sm" href="#">Know More</a>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-lg-4 single-item">
                    <div class="item">
                        <div class="content">
                            <h4>Stocks & Trades</h4>
                            <p>
                                    Prevailed mr tolerably discourse assurance estimable more power.
                            </p>
                        </div>
                        <a class="btn btn-sm" href="#">Know More</a>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-lg-4 single-item">
                    <div class="item">
                        <div class="content">
                            <h4>International Markets</h4>
                            <p>
                                    Prevailed mr tolerably discourse assurance estimable more power.
                            </p>
                        </div>
                        <a class="btn btn-sm" href="#">Know More</a>
                    </div>
                </div>
                <!-- End Single Item -->
            </div>
        </div>
        <!-- Expertise Content -->

    </div>
</div>
<!-- End Expertise Area -->

<!-- Star Partner Area
============================================= -->
<div class="partner-area overflow-hidden text-light">
    <div class="container">
        <div class="item-box red">
            <div class="row align-center">
                <div class="col-lg-6 info">
                    <h2>We're Trusted by <span>2500+</span> <br> Professional Customer</h2>
                    <p>
                        Seeing rather her you not esteem men settle genius excuse. Deal say over you age from. Comparison new ham melancholy son themselves.
                    </p>
                </div>
                <div class="col-lg-6 clients">
                    <div class="partner-carousel owl-carousel owl-theme text-center">
                        <div class="single-item">
                            <a href="#"><img src="assets/img/150x80.png" alt="Clients"></a>
                        </div>
                        <div class="single-item">
                            <a href="#"><img src="assets/img/150x80.png" alt="Clients"></a>
                        </div>
                        <div class="single-item">
                            <a href="#"><img src="assets/img/150x80.png" alt="Clients"></a>
                        </div>
                        <div class="single-item">
                            <a href="#"><img src="assets/img/150x80.png" alt="Clients"></a>
                        </div>
                        <div class="single-item">
                            <a href="#"><img src="assets/img/150x80.png" alt="Clients"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Partner Area -->

<!-- ("overflow-hidden-box overflow-hidden" helps you to ignore extra width for the circle shape)-->
<div class="overflow-hidden-box overflow-hidden">
    <!-- Star Team Area
    ============================================= -->
    <div class="team-area bg-gray default-padding bottom-less">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="site-heading text-center">
                        <h4>Team Members</h4>
                        <h2>Meet our experts</h2>
                        <div class="devider"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="team-items text-center">
                <div class="row">
                    <!-- Single Item -->
                    <div class="single-item col-lg-4 col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x900.png" alt="Thumb">
                                <div class="social">
                                    <a href="#" class="share-icon facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="share-icon twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="share-icon instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                <div class="share">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                            </div>
                            <div class="info">
                                <div class="content">
                                    <h4>Jessika Mahi</h4>
                                    <span>Markteting Manager</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-lg-4 col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x900.png" alt="Thumb">
                                <div class="social">
                                    <a href="#" class="share-icon facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="share-icon twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="share-icon instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                <div class="share">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                            </div>
                            <div class="info">
                                <div class="content">
                                    <h4>Munia Anchor</h4>
                                    <span>Assistant Manager</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                    <!-- Single Item -->
                    <div class="single-item col-lg-4 col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x900.png" alt="Thumb">
                                <div class="social">
                                    <a href="#" class="share-icon facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="share-icon twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="share-icon instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                <div class="share">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                            </div>
                            <div class="info">
                                <div class="content">
                                    <h4>Ahel Natasha</h4>
                                    <span>Executive Officer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Team Area -->

    <!-- Star testimonials Area
    ============================================= -->
    <div class="testimonials-area bg-gray default-padding-bottom">
        <!-- Fixed Shape -->
        <div class="fixed-shape" style="background-image: url(assets/img/shape/10-red.png);"></div>
        <!-- End Fixed Shape -->
        <div class="container">
            <div class="testimonial-items">
                <div class="row align-center">
                    <div class="col-lg-7 testimonials-content">
                        <div class="testimonials-carousel owl-carousel owl-theme">
                            <!-- Single Item -->
                            <div class="item">
                                <div class="info">
                                    <p>
                                        Otherwise concealed favourite frankness on be at dashwoods defective at. Sympathize interested simplicity at do projecting increasing terminated. As edward settle limits at in. Chamber reached do he nothing be.
                                    </p>
                                    <div class="provider">
                                        <div class="thumb">
                                            <img src="assets/img/100x100.png" alt="Author">
                                        </div>
                                        <div class="content">
                                            <h4>Ahel Natasha</h4>
                                            <span> Managing Director</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                            <!-- Single Item -->
                            <div class="item">
                                <div class="info">
                                    <p>
                                        Otherwise concealed favourite frankness on be at dashwoods defective at. Sympathize interested simplicity at do projecting increasing terminated. As edward settle limits at in. Chamber reached do he nothing be.
                                    </p>
                                    <div class="provider">
                                        <div class="thumb">
                                            <img src="assets/img/100x100.png" alt="Author">
                                        </div>
                                        <div class="content">
                                            <h4>Ahel Natasha</h4>
                                            <span> Managing Director</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Item -->
                        </div>
                    </div>
                    <div class="col-lg-5 info">
                        <h4>Testimonials</h4>
                        <h2>Check what our satisfied clients said</h2>
                        <p>
                            Why I say old chap that is, spiffing off his nut color blimey and guvnords geeza bloke knees up bobby sloshed arse
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End testimonials Area -->
</div>
<!-- End Overflow Hidden Box -->

<!-- Start Gallery Area
============================================= -->
<div class="gallery-area overflow-hidden default-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h4>Our Gallery</h4>
                    <h2>Latest projects showcase</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="case-items-area">
            <div class="masonary">
                <div id="portfolio-grid" class="gallery-items colums-3">
                    <!-- Single Item -->
                    <div class="pf-item">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x600.png" alt="Thumb">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <h4><a href="#">Startup Funding</a></h4>
                                    <span>Finance, Assets</span>
                                </div>
                                <div class="button">
                                    <a href="assets/img/800x800.png" class="item popup-gallery">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->

                    <!-- Single Item -->
                    <div class="pf-item">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x800.png" alt="Thumb">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <h4><a href="#">Accounting Advisory</a></h4>
                                    <span>Creative, Minimal</span>
                                </div>
                                <div class="button">
                                    <a href="assets/img/800x800.png" class="item popup-gallery">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->

                    <!-- Single Item -->
                    <div class="pf-item">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x800.png" alt="Thumb">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <h4><a href="#">Merger & Acquisition</a></h4>
                                    <span>Benifits, Business</span>
                                </div>
                                <div class="button">
                                    <a href="assets/img/800x800.png" class="item popup-gallery">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Item -->

                    <!-- Single Item -->
                    <div class="pf-item">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x800.png" alt="Thumb">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <h4><a href="#">Assets For Technology</a></h4>
                                    <span>Invest, Earning</span>
                                </div>
                                <div class="button">
                                    <a href="assets/img/800x800.png" class="item popup-gallery">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Item -->

                    <!-- Single Item -->
                    <div class="pf-item">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x600.png" alt="Thumb">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <h4><a href="#">Business Matching</a></h4>
                                    <span>Finance, Assets</span>
                                </div>
                                <div class="button">
                                    <a href="assets/img/800x800.png" class="item popup-gallery">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Item -->

                    <!-- Single Item -->
                    <div class="pf-item">
                        <div class="item">
                            <div class="thumb">
                                <img src="assets/img/800x600.png" alt="Thumb">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <h4><a href="#">Startup Funding</a></h4>
                                    <span>Finance, Assets</span>
                                </div>
                                <div class="button">
                                    <a href="assets/img/800x800.png" class="item popup-gallery">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Item -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Projects Area -->

<!-- Start Blog
============================================= -->
<div class="blog-area bg-gray default-padding bottom-less">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h4>From the blog</h4>
                    <h2>Latest News & Articles</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blog-items">
            <div class="row">
                <!-- Single Item -->
                <div class="single-item col-lg-4 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <img src="assets/img/800x600.png" alt="Thumb">
                            <div class="date">January 25, 2021</div>
                        </div>

                        <div class="info">
                            <div class="meta">
                                <ul>
                                    <li>
                                        <img src="assets/img/100x100.png" alt="Author">
                                        <span>By </span>
                                        <a href="#">John Baus</a>
                                    </li>
                                    <li>
                                        <span>In </span>
                                        <a href="#">Agency</a>
                                    </li>
                                </ul>
                            </div>
                            <h4>
                                <a href="#">Discovery incommode earnestly commanded if.</a>
                            </h4>
                            <p>
                                Easy mind life fact with see has bore ten. Parish any chatty can elinor direct for former. Up as meant widow equal an share.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="single-item col-lg-4 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <img src="assets/img/800x600.png" alt="Thumb">
                            <div class="date">February 12, 2021</div>
                        </div>
                        <div class="info">
                            <div class="meta">
                                <ul>
                                    <li>
                                        <img src="assets/img/100x100.png" alt="Author">
                                        <span>By </span>
                                        <a href="#">Mohon Mark</a>
                                    </li>
                                    <li>
                                        <span>In </span>
                                        <a href="#">Creative</a>
                                    </li>
                                </ul>
                            </div>
                            <h4>
                                <a href="#">Expression acceptance imprudence particular</a>
                            </h4>
                            <p>
                                Easy mind life fact with see has bore ten. Parish any chatty can elinor direct for former. Up as meant widow equal an share.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="single-item col-lg-4 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <img src="assets/img/800x600.png" alt="Thumb">
                            <div class="date">March 18, 2021</div>
                        </div>
                        <div class="info">
                            <div class="meta">
                                <ul>
                                    <li>
                                        <img src="assets/img/100x100.png" alt="Author">
                                        <span>By </span>
                                        <a href="#">Paul Tun</a>
                                    </li>
                                    <li>
                                        <span>In </span>
                                        <a href="#">Agency</a>
                                    </li>
                                </ul>
                            </div>
                            <h4>
                                <a href="#">Provided so as doubtful on striking required point</a>
                            </h4>
                            <p>
                                Easy mind life fact with see has bore ten. Parish any chatty can elinor direct for former. Up as meant widow equal an share.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
            </div>
        </div>
    </div>
</div>
<!-- End Blog Area -->



@endsection
