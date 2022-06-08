@php
$phone = setting('contact.phone');
$email = setting('contact.email');
$siteTitle = setting('site.title')
@endphp
{{-- @if (auth()->check() && auth()->user()->isAdmin())
<div class="py-3 px-3 text-light position-fixed"
    style="top: 0; left: 0; z-index: 10000;width: 220px;background-color: #000;">
    <div class="container-fluid">
        <a href="{{ url('admin') }}" class="text-light">Панель управления</a>
    </div>
</div>
@endif --}}

<header id="home">

    <!-- Start Navigation -->
    <nav class="navbar navbar-default navbar-sticky bootsnav">

        <!-- Start Top Search -->
        <div class="top-search">
            <div class="container">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search">
                    <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                </div>
            </div>
        </div>
        <!-- End Top Search -->

        <div class="container">

            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#"><i class="ti-search"></i></a></li>
                    <li>
                        <a href="#">
                            RU
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End Atribute Navigation -->

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ $logo }}" class="logo" alt="{{ $siteTitle }}">
                </a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-center" data-in="#" data-out="#">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" >Home</a>
                        <ul class="dropdown-menu">
                            <li><a href="index.html">Home Version One</a></li>
                            <li><a href="index-2.html">Home Version Two</a></li>
                            <li><a href="index-3.html">Home Version Three</a></li>
                            <li><a href="index-4.html">Home Version Four</a></li>
                            <li><a href="index-op.html">Onepage Version One</a></li>
                            <li><a href="index-op-2.html">Onepage Version Two</a></li>
                            <li><a href="index-op-3.html">Onepage Version Three</a></li>
                            <li><a href="index-op-4.html">Onepage Version Four</a></li>
                        </ul>
                    </li>
                    <li class="dropdown megamenu-fw">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages</a>
                        <ul class="dropdown-menu megamenu-content" role="menu">
                            <li>
                                <div class="row">
                                    <div class="col-menu col-lg-3">
                                        <h6 class="title">Gallery Grid</h6>
                                        <div class="content">
                                            <ul class="menu-col">
                                                <li><a href="gallery-grid-2-colum.html">Grid Two Colum</a></li>
                                                <li><a href="gallery-grid-3-colum.html">Grid Three Colum</a></li>
                                                <li><a href="gallery-grid-4-colum.html">Grid Four Colum</a></li>
                                                <li><a href="gallery-mixed-colum.html">Mixed Colum</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- end col-3 -->
                                    <div class="col-menu col-lg-3">
                                        <h6 class="title">Gallery Masonary</h6>
                                        <div class="content">
                                            <ul class="menu-col">
                                                <li><a href="gallery-masonary-2-colum.html">Masonary Two Colum</a></li>
                                                <li><a href="gallery-masonary-3-colum.html">Masonary Three Colum</a></li>
                                                <li><a href="gallery-masonary-4-colum.html">Masonary Four Colum</a></li>
                                                <li><a href="gallery-carousel.html">Gallery Carousel</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- end col-3 -->
                                    <div class="col-menu col-lg-3">
                                        <h6 class="title">Other Pages</h6>
                                        <div class="content">
                                            <ul class="menu-col">
                                                <li><a href="about-us.html">About us</a></li>
                                                <li><a href="career.html">Career</a></li>
                                                <li><a href="terms-conditions.html">Terms Conditions</a></li>
                                                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                                <li><a href="faq.html">Faq</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- end col-3 -->
                                    <div class="col-menu col-lg-3">
                                        <h6 class="title">Additional Pages</h6>
                                        <div class="content">
                                            <ul class="menu-col">
                                                <li><a href="login.html">login</a></li>
                                                <li><a href="register.html">register</a></li>
                                                <li><a href="404.html">Error Page</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- end col-3 -->
                                </div><!-- end row -->
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Team</a>
                        <ul class="dropdown-menu">
                            <li><a href="team.html">Team Members</a></li>
                            <li><a href="team-single.html">Team Single</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Services</a>
                        <ul class="dropdown-menu">
                            <li><a href="services.html">Services Version One</a></li>
                            <li><a href="services-2.html">Services Version Two</a></li>
                            <li><a href="services-3.html">Services Version Three</a></li>
                            <li><a href="services-single.html">Services Details</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Blog</a>
                        <ul class="dropdown-menu">
                            <li><a href="blog-standard.html">Blog Standard</a></li>
                            <li><a href="blog-with-sidebar.html">Blog With Sidebar</a></li>
                            <li><a href="blog-2-colum.html">Blog Grid Two Colum</a></li>
                            <li><a href="blog-3-colum.html">Blog Grid Three Colum</a></li>
                            <li><a href="blog-single.html">Blog Single</a></li>
                            <li><a href="blog-single-with-sidebar.html">Blog Single With Sidebar</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Contact Us</a>
                        <ul class="dropdown-menu">
                            <li><a href="contact.html">Version One</a></li>
                            <li><a href="contact-2.html">Version Two</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>

    </nav>
    <!-- End Navigation -->

</header>
