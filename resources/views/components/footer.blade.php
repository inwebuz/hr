@php
$siteTitle = setting('site.title');
$phone = setting('contact.phone');
$email = setting('contact.email');
$map = setting('contact.map');
$telegram = setting('contact.telegram');
@endphp

<footer class="bg-dark text-light">
    <div class="container">
        <div class="f-items default-padding">
            <div class="row">
                <div class="col-lg-4 col-md-6 item">
                    <div class="f-item about">
                        <img src="assets/img/logo-light.png" alt="Logo">
                        <p>
                            Excellence decisively nay man yet impression for contrasted remarkably. There spoke happy for you are out. Fertile how old address did showing.
                        </p>
                        <form action="#">
                            <input type="email" placeholder="Your Email" class="form-control" name="email">
                            <button type="submit"> <i class="arrow_right"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 item">
                    <div class="f-item link">
                        <h4 class="widget-title">Quick LInk</h4>
                        <ul>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Home</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> About us</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Compnay History</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Features</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Blog Page</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 item">
                    <div class="f-item link">
                        <h4 class="widget-title">Community</h4>
                        <ul>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Career</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Leadership</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Strategy</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Services</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> History</a>
                            </li>
                            <li>
                                <a href="#"><i class="fas fa-angle-right"></i> Components</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 item">
                    <div class="f-item contact-widget">
                        <h4 class="widget-title">Contact Info</h4>
                        <div class="address">
                            <ul>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="content">
                                        <strong>Address:</strong>
                                        5919 Trussville Crossings Pkwy, Birmingham
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="content">
                                        <strong>Email:</strong>
                                        <a href="mailto:info@validtheme.com">info@validtheme.com</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="content">
                                        <strong>Phone:</strong>
                                        <a href="tel:2151234567">+123 34598768</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-box">
                <div class="row">
                    <div class="col-lg-6">
                        <p>&copy; Copyright 2021. All Rights Reserved by <a href="#">validthemes</a></p>
                    </div>
                    <div class="col-lg-6 text-right link">
                        <ul>
                            <li>
                                <a href="#">Terms</a>
                            </li>
                            <li>
                                <a href="#">Privacy</a>
                            </li>
                            <li>
                                <a href="#">Support</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>

{{-- <footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row footer-top__wrap">
                <div class="col-lg-6 footer-contacts mb-3 mb-lg-0">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ $logoLight }}" alt="{{ $siteTitle }}">
                        </a>
                    </div>
                    <a href="tel:{{ Helper::phone($phone) }}" class="phone-link">{{ $phone }}</a>
                    <a href="mailto:{{ $email }}" class="mail-link text-darkyellow">{{ $email }}</a>
                    <a href="{{ route('contacts') }}" class="address-link text-darkyellow">{{ $address }}</a>
                    <div class="map d-none d-lg-block">
                        {!! $map !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row h-100">
                        <div class="col-sm-6 footer-nav mb-3 mb-lg-0">
                            <h4 data-toggle="collapse">
                                <span>{{ __('main.for_buyers') }}</span>
                                <svg width="16" height="16" fill="#fff">
                                    <use xlink:href="#arrow"></use>
                                </svg>
                            </h4>
                            <ul class="footer-nav__list collapse">
                                @foreach ($menuBuyers as $item)
                                <li>
                                    <a href="{{ $item->getTranslatedAttribute('url') }}">{{ $item->getTranslatedAttribute('title') }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-6 footer-nav">
                            <h4 data-toggle="collapse">
                                <span>{{ __('main.useful') }}</span>
                                <svg width="16" height="16" fill="#fff">
                                    <use xlink:href="#arrow"></use>
                                </svg>
                            </h4>
                            <ul class="footer-nav__list collapse">
                                @foreach ($menuUseful as $item)
                                <li>
                                    <a href="{{ $item->getTranslatedAttribute('url') }}">{{ $item->getTranslatedAttribute('title') }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-12 footer-nav-bottom mt-auto d-none d-sm-block">
                            <ul class="footer-nav-bottom__list">
                                @foreach ($footerMenuItems as $item)
                                    <li>
                                        <a href="{{ $item->url }}">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                                <li class="ml-sm-auto">
                                    <a href="#contact-modal" data-toggle="modal" class="btn secondary sm radius-4">{{ __('main.ask_a_question') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row footer-bottom__wrap">
                <div class="col-lg-4 col-sm-6">
                    <p class="copyright-text">&copy; 2020-{{ date('Y') }} <span class="text-darkyellow">{{ $siteTitle }}</span> | {{ __('main.all_rights_reserved') }}</p>
                </div>
                <div class="col-lg-4">
                    <ul class="footer-social-list">
                        @include('partials.social_list')
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="footer-logo text-light" href="https://inweb.uz" target="_blank">
                        <p>{{ __('main.developer') }} —</p>
                        <img src="{{ asset('images/devlogo-light.png') }}" alt="Inweb.uz">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer> --}}


{{-- <div class="accept-cookie">
    <div class="rounded bg-light text-dark border py-2 px-3 ">
        {{ __('main.site_uses_cookie') }}
        <a href="#" class="accept-cookie-btn">{{ __('main.to_accept2') }}</a>
    </div>
</div> --}}

<!-- Contact Modal -->
<div class="modal fade" id="contact-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('contacts.send') }}" class="contact-form">
                @csrf
                <input type="hidden" name="product_id" value="">
                <div class="modal-body">
                    <h5 class="modal-title">
                        {{ __('main.form.send_request') }}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times"></i></span>
                        </button>
                    </h5>
                    <br>
                    <div class="form-result"></div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name"
                            placeholder="{{ __('main.form.your_name') }}" required />
                    </div>
                    <div class="form-group">
                        <input class="form-control phone-input-mask" type="text" name="phone"
                            placeholder="{{ __('main.form.phone') }}" required />
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="4"
                            placeholder="{{ __('main.form.message') }}"></textarea>
                    </div>

                    <div class="row gutters-5 mb-4">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <input type="text" name="captcha" class="form-control"
                                placeholder="{{ __('main.form.security_code') }}" required>
                        </div>
                        <div class="col-lg-6">
                            <div class="captcha-container">
                                <img src="{{ asset('images/captcha.png') }}" alt="Captcha" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary radius-6" type="submit">
                            {{ __('main.form.send') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Phone Call Modal -->
<div class="modal fade" id="phone-call-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('contacts.send') }}" class="contact-form">
                @csrf
                <input type="hidden" name="type" value="{{ \App\Contact::TYPE_CALLBACK }}">

                <div class="modal-body">
                    <h5 class="modal-title" id="phone-call-modal-label">
                        {{ __('main.callback') }}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times"></i></span>
                        </button>
                    </h5>
                    <br>
                    <div class="form-result"></div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name"
                            placeholder="{{ __('main.form.your_name') }}" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control phone-input-mask" type="text" name="phone"
                            placeholder="{{ __('main.form.phone') }}" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="message"
                            placeholder="{{ __('main.what_time_should_we_call_you_back') }}" required>
                    </div>

                    <div class="row gutters-5 mb-4">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <input type="text" name="captcha" class="form-control"
                                placeholder="{{ __('main.form.security_code') }}" required>
                        </div>
                        <div class="col-lg-6">
                            <div class="captcha-container">
                                <img src="{{ asset('images/captcha.png') }}" alt="Captcha" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary radius-6" type="submit">
                            {{ __('main.form.send') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cart Modal -->
<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="cart-message mb-3 mt-2 text-center h4">
                    {{ __('main.product_added_to_cart') }}
                </h4>
                <div class="d-flex flex-nowrap justify-content-center">
                    <button type="button" class="btn secondary radius-6 mx-1 mb-2" data-dismiss="modal">
                        {{ __('main.continue_shopping') }}
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-primary radius-6 mb-2">
                        {{ __('main.go_to_cart') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Regions list Modal -->
<div class="modal fade" id="regions-list-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="mb-3 mt-2 text-center h4">
                    {{ __('main.choose_a_region') }}
                </h4>
                <div class="text-center">
                    <form action="{{ route('region.set') }}" method="post" class="regions-list-form">

                        @csrf

                        <div class="form-result"></div>

                        <div class="list-group regions-list-group">
                            @foreach ($regions as $region)
                            <span class="list-group-item @if ($region->id ==
                                    $currentRegionID) active disabled @endif" data-region-id="{{ $region->id }}">{{
                                $region->getTranslatedAttribute('short_name') }}</span>
                            @endforeach
                        </div>
                        <input type="hidden" name="region_id" value="">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
