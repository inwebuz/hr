@php
$siteTitle = setting('site.title');
$phone = setting('contact.phone');
$email = setting('contact.email');
$map = setting('contact.map');
$telegram = setting('contact.telegram');
@endphp

<footer class="footer">
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
</footer>

<div class="overlay"></div>

<a href="{{ route('compare.index') }}" class="compare-page-link btn btn-primary xs radius-6">{{ __('main.compare_list') }}</a>

<!-- nav-bottom -->
<div class="nav-bottom d-lg-none">
    <div class="btn-items">
        <div class="btn-item">
            <a href="#" class="icon-btn">
                <svg width="26" height="26" fill="#666">
                    <use xlink:href="#main"></use>
                </svg>
                <span>{{ __('main.nav.home') }}</span>
            </a>
        </div>
        <div class="btn-item">
            <a href="{{ route('categories') }}" class="icon-btn">
                <svg width="26" height="26" fill="#666">
                    <use xlink:href="#list"></use>
                </svg>
                <span>{{ __('main.nav.catalog') }}</span>
            </a>
        </div>
        <div class="btn-item">
            <a href="{{ route('cart.index') }}" class="icon-btn">
                <span class="badge cart_count">{{ $cartQuantity }}</span>
                <svg width="26" height="26" fill="#666">
                    <use xlink:href="#cart"></use>
                </svg>
                <span>{{ __('main.cart') }}</span>
            </a>
        </div>
        <div class="btn-item">
            <a href="{{ route('wishlist.index') }}" class="icon-btn">
                <span class="badge wishlist_count">{{ $wishlistQuantity }}</span>
                <svg width="26" height="26" fill="#666">
                    <use xlink:href="#heart"></use>
                </svg>
                <span>{{ __('main.featured') }}</span>
            </a>
        </div>
        <div class="btn-item">
            @guest
                <a href="{{ route('login') }}" class="icon-btn">
                    <svg width="26" height="26" fill="#666">
                        <use xlink:href="#user"></use>
                    </svg>
                    <span>{{ __('main.login') }}</span>
                </a>
            @else
                <a href="{{ route('profile.show') }}" class="icon-btn">
                    <svg width="26" height="26" fill="#666">
                        <use xlink:href="#user"></use>
                    </svg>
                    <span>{{ __('main.profile') }}</span>
                </a>
            @endguest
        </div>
    </div>
</div>

<div class="screen-icons">
    <span class="screen-icons-btn screen-phone-call-button" data-toggle="modal" data-target="#phone-call-modal" title="{{ __('main.callback') }}">
        <svg viewBox="0 0 920 920" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d=" M 215.93 57.69 C 218.59 58.28 221.32 58.38 224.04 58.44 C 229.90 59.12 235.62 60.67 241.22 62.50 C 254.07 66.87 265.35 74.66 275.75 83.21 C 285.47 91.82 294.58 101.14 302.83 111.16 C 320.84 133.16 337.74 156.42 349.48 182.43 C 353.59 192.60 357.03 203.14 358.46 214.04 C 358.66 220.01 358.83 225.99 358.36 231.95 C 356.38 244.34 351.54 256.35 344.06 266.45 C 333.64 281.63 319.96 294.08 307.11 307.13 C 302.01 312.33 296.00 317.14 293.52 324.25 C 289.27 334.40 290.94 345.66 293.83 355.92 C 294.26 357.20 294.64 358.50 295.06 359.79 C 296.47 364.01 298.14 368.13 300.01 372.17 C 301.44 376.08 303.35 379.79 305.49 383.35 C 312.74 396.65 321.14 409.31 330.22 421.42 C 339.54 434.10 349.48 446.32 359.80 458.19 C 361.66 460.65 363.91 462.77 365.94 465.08 C 375.31 476.00 385.23 486.44 395.06 496.95 C 410.55 513.01 426.17 528.98 442.46 544.24 C 447.68 549.11 452.64 554.26 458.03 558.95 C 466.22 566.43 474.33 574.01 482.83 581.14 C 488.33 586.38 494.38 590.96 500.21 595.82 C 505.43 600.47 511.29 604.29 516.63 608.79 C 525.83 615.95 535.61 622.29 545.31 628.73 C 561.93 638.76 579.55 648.51 599.12 650.92 C 602.63 651.61 606.31 651.82 609.81 650.93 C 616.05 650.53 622.07 647.86 626.95 644.00 C 647.44 624.65 665.69 601.58 691.85 589.52 C 703.25 584.90 715.81 582.27 728.10 584.01 C 734.46 584.68 740.70 586.20 746.85 587.93 C 762.26 592.65 776.51 600.47 790.13 608.96 C 794.17 611.46 798.17 614.06 802.01 616.87 C 822.59 631.25 842.62 646.83 859.22 665.79 C 871.17 679.65 880.89 695.95 884.21 714.14 C 884.23 714.70 884.29 715.80 884.32 716.36 C 885.68 723.17 884.77 730.10 884.10 736.93 C 881.03 750.09 875.74 762.80 867.87 773.84 C 866.46 776.03 864.89 778.12 863.27 780.17 C 862.30 781.53 861.30 782.87 860.35 784.25 C 843.28 805.12 822.85 822.81 803.79 841.77 C 803.36 842.12 802.51 842.82 802.09 843.17 C 800.80 844.22 799.52 845.28 798.25 846.36 C 791.64 851.31 784.04 854.65 776.19 857.08 C 773.72 857.79 771.23 858.41 768.75 859.07 C 762.89 860.52 756.91 861.32 750.95 862.11 C 745.69 863.13 740.31 862.54 734.99 862.68 C 729.65 862.36 724.24 863.14 718.97 861.99 C 697.61 859.92 676.43 855.82 655.80 849.96 C 650.01 847.99 644.06 846.55 638.33 844.43 C 634.05 843.22 629.92 841.57 625.66 840.29 C 620.35 838.29 615.10 836.15 609.79 834.18 C 604.80 832.13 599.79 830.15 594.86 827.96 C 593.44 827.40 592.03 826.81 590.62 826.26 C 570.76 817.31 551.14 807.81 532.14 797.14 C 515.21 787.81 498.73 777.71 482.45 767.31 C 481.15 766.36 479.84 765.47 478.54 764.55 C 466.72 757.21 455.56 748.87 444.14 740.93 C 438.32 736.59 432.47 732.29 426.56 728.08 L 426.49 727.76 C 419.71 722.68 413.04 717.48 406.38 712.27 C 402.42 708.41 397.66 705.52 393.66 701.72 C 382.87 693.31 372.95 683.82 362.30 675.28 C 358.85 671.81 355.39 668.34 351.52 665.35 C 347.95 662.46 345.32 658.40 341.26 656.15 L 341.52 655.96 C 335.09 650.50 329.59 644.04 323.18 638.56 L 322.42 638.55 L 322.53 637.43 L 321.36 637.58 L 321.59 636.37 L 320.34 636.64 L 320.61 635.36 L 319.30 635.66 L 319.68 634.61 L 318.52 634.49 L 318.45 633.37 L 317.82 633.60 C 316.96 632.64 316.10 631.71 315.23 630.78 C 313.42 629.13 311.69 627.38 310.11 625.53 L 309.38 625.57 L 309.57 624.45 L 308.43 624.59 L 308.55 623.44 L 307.38 623.57 L 307.57 622.38 L 306.34 622.63 L 306.60 621.36 L 305.66 621.68 L 305.33 620.64 L 304.28 620.40 L 304.68 619.49 L 303.84 619.48 C 298.21 612.27 290.91 606.51 285.02 599.49 L 284.07 599.72 L 284.84 598.45 L 283.92 598.52 C 280.91 594.25 276.60 591.12 273.55 586.88 C 267.12 580.13 261.11 573.01 254.99 565.99 C 251.37 561.71 247.60 557.56 244.20 553.10 C 242.73 551.48 241.23 549.88 239.88 548.16 C 229.82 535.65 219.58 523.28 210.21 510.23 C 209.74 509.70 209.27 509.17 208.79 508.65 C 201.19 498.05 193.46 487.55 186.07 476.80 C 173.44 458.17 161.41 439.15 150.17 419.67 C 149.72 418.81 149.28 417.96 148.84 417.11 C 139.25 400.35 130.16 383.26 122.22 365.65 C 116.93 355.03 112.50 344.02 108.06 333.03 C 107.65 332.09 107.23 331.16 106.81 330.24 C 101.53 316.03 96.48 301.69 92.35 287.12 C 85.31 263.65 81.40 239.32 79.28 214.96 C 78.36 202.55 80.09 190.19 82.06 177.98 C 84.17 169.62 86.33 161.16 90.37 153.48 C 95.05 143.67 103.27 136.33 110.79 128.73 C 121.11 117.43 131.97 106.63 142.90 95.90 C 157.39 82.60 173.10 69.77 191.82 62.97 C 199.00 60.41 206.51 58.43 214.17 58.23 C 214.61 58.09 215.49 57.82 215.93 57.69 Z" />
        </svg>
    </span>
    @if ($telegram)
    <a href="{{ $telegram }}" target="_blank" rel="nofollow" class="screen-icons-btn screen-telegram-button" title="Telegram">
        <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M41.4193 7.30899C41.4193 7.30899 45.3046 5.79399 44.9808 9.47328C44.8729 10.9883 43.9016 16.2908 43.1461 22.0262L40.5559 39.0159C40.5559 39.0159 40.3401 41.5048 38.3974 41.9377C36.4547 42.3705 33.5408 40.4227 33.0011 39.9898C32.5694 39.6652 24.9068 34.7955 22.2086 32.4148C21.4531 31.7655 20.5897 30.4669 22.3165 28.9519L33.6487 18.1305C34.9438 16.8319 36.2389 13.8019 30.8426 17.4812L15.7331 27.7616C15.7331 27.7616 14.0063 28.8437 10.7686 27.8698L3.75342 25.7055C3.75342 25.7055 1.16321 24.0823 5.58815 22.459C16.3807 17.3729 29.6555 12.1786 41.4193 7.30899Z" fill="black"/>
        </svg>
    </a>
    @endif
</div>

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
