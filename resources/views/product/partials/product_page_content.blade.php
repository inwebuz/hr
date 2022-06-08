<div class="product-page-content" data-product-id="{{ $product->id }}">

    <section class="product-view">
        <div class="container">

            @can('edit', $product)
            <div class="my-4">
                <a href="{{ url('admin/products/' . $product->id . '/edit') }}" class="btn btn-lg btn-primary"
                    target="_blank">Редактировать (SKU: {{ $product->sku }}, ID: {{ $product->id }})</a>
            </div>
            @endcan

            <div class="content-top">
                <h1>{{ $product->h1_name ?: Helper::seo('product', 'h1_name', $seoReplacements) }}</h1>
                @if ($brand)
                @if ($brand->image)
                <a href="{{ $brand->url }}" class="ml-3" title="{{ $brand->name }}">
                    <img src="{{ $brand->small_img }}" alt="{{ $brand->name }}" class="img-fluid">
                </a>
                @else
                <a href="{{ $brand->url }}" class="brand-img" title="{{ $brand->name }}">{{ $brand->name }}</a>
                @endif
                @endif
            </div>

            <div class="row product-wrap">
                <div class="col-lg-5 mb-3 mb-lg-0">
                    <div class="product-preview">
                        <div class="product-preview__swiper swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="swiper-item radius-6 zoomImg">
                                        <div class="swiper-item__info">
                                            @if ($product->isBestseller())
                                            <strong class="status radius-6 violet-out">{{ __('main.bestseller') }}</strong>
                                            @endif
                                            @if ($product->isDiscounted())
                                            <strong class="discount radius-6 bg-danger">{{ __('main.discount') }} -{{ $product->discount_percent }}%</strong>
                                            @endif
                                        </div>
                                        <a href="{{ $product->img }}" class="d-block" data-fancybox="gallery">
                                            <img src="{{ $product->medium_img }}" alt="{{ $product->name }}" class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                                @foreach ($product->medium_imgs as $key => $meduimImg)
                                <div class="swiper-slide">
                                    <div class="swiper-item radius-6 zoomImg">
                                        <a href="{{ $product->imgs[$key] }}" class="d-block" data-fancybox="gallery">
                                            <img src="{{ $meduimImg }}" alt="{{ $product->name . ' ' . $key }}" class="img-fluid">
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination d-lg-none"></div>
                        </div>
                        <div class="product-preview__thumbs swiper-container d-none d-lg-block">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="swiper-item radius-6">
                                        <img src="{{ $product->micro_img }}" alt="{{ $product->name }}" class="img-fluid">
                                    </div>
                                </div>
                                @foreach ($product->micro_imgs as $key => $microImg)
                                <div class="swiper-slide">
                                    <div class="swiper-item radius-6">
                                        <img src="{{ $microImg }}" alt="{{ $product->name . ' ' . $key }}" class="img-fluid">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="product-characters">
                        <div class="product-characters__top">
                            <ul class="star-list mr-3">
                                <li>
                                    <svg width="16" height="16" fill="#e31235">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                                <li>
                                    <svg width="16" height="16" fill="#e31235">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                                <li>
                                    <svg width="16" height="16" fill="#e31235">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                                <li>
                                    <svg width="16" height="16" fill="#e31235">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                                <li>
                                    <svg width="16" height="16" fill="#e31235">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                            </ul>
                            <span class="mr-3">{{ __('main.reviews2') }}: {{ $reviewsQuantity }}</span>
                            <ul class="actions">
                                <li>
                                    <a href="javascript:;"
                                        class="radius-8 @if(!app('wishlist')->get($product->id)) add-to-wishlist-btn @else remove-from-wishlist-btn active @endif only-icon"
                                        data-id="{{ $product->id }}" data-add-url="{{ route('wishlist.add') }}"
                                        data-remove-url="{{ route('wishlist.delete', $product->id) }}" data-name="{{ $product->name }}"
                                        data-price="{{ $product->current_price }}"
                                        data-add-text="<svg width='20' height='20' fill='currentColor'><use xlink:href='#heart'></use></svg>"
                                        data-delete-text="<svg width='20' height='20' fill='currentColor'><use xlink:href='#heart'></use></svg>">
                                        <svg width="20" height="20" fill="currentColor">
                                            <use xlink:href="#heart"></use>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;"
                                        class="radius-8 @if(!app('compare')->get($product->id)) add-to-compare-btn @else remove-from-compare-btn active @endif only-icon"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->current_price }}"
                                        data-add-url="{{ route('compare.add') }}"
                                        data-delete-url="{{ route('compare.delete', ['id' => $product->id]) }}"
                                        title="@if(!app('compare')->get($product->id)) {{ __('main.add_to_compare') }} @else {{ __('main.delete_from_compare') }} @endif"
                                        data-add-text="{{ __('main.add_to_compare') }}" data-delete-text="{{ __('main.delete_from_compare') }}">
                                        <svg width="20" height="20" fill="currentColor">
                                            <use xlink:href="#rating"></use>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        @if ($productGroup)
                            @include('product.partials.product_group')
                        @endif

                        {{-- <div class="my-4">
                            {{ $product->description ?: Helper::seo('product', 'description', $seoReplacements) }}
                        </div> --}}

                        <ul class="product-characters__list" data-target="more-container">
                            @if ($brand)
                            <li>
                                <span>{{ __('main.brand') }}</span>
                                <div class="col"></div>
                                <strong>{{ $brand->name }}</strong>
                            </li>
                            @endif
                            @if (!$attributes->isEmpty())
                            @foreach ($attributes as $attribute)
                            <li>
                                <span>{{ $attribute->name }}</span>
                                <div class="col"></div>
                                <strong>
                                    @foreach ($attribute->attributeValues as $attributeValue)
                                    {{ $attributeValue->name }}@if (!$loop->last){{ ',' }}@endif
                                    @endforeach
                                </strong>
                            </li>
                            @if($loop->index > 5) @break @endif
                            @endforeach
                            @endif
                        </ul>
                        @if (!$attributes->isEmpty())
                        <div class="my-3">
                            <a href="javascript:;" class="show-all-specifications-btn">{{ __('main.all_specifications') }}</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="product-head flex-nowrap">
                        <span class="product-head__status radius-6 text-nowrap mr-2 @if($isAvailable) success @else danger @endif">@if($isAvailable) {{ __('main.in_stock') }} @else {{ __('main.not_in_stock') }} @endif</span>
                        <span class="product-head__code">{{ __('main.sku') }}: {{ $product->sku }}</span>
                    </div>
                    @if($isAvailable)
                    <div class="product-about radius-8">
                        @if ($isDiscounted)
                            <span class="price-info">{{ __('main.sale_price') }}</span>
                            <p class="text-price text-danger">{{ Helper::formatPrice($product->current_price) }}</p>
                            <del>{{ Helper::formatPrice($product->current_not_sale_price) }}</del>
                        @else
                            <span class="price-info">{{ __('main.price') }}</span>
                            <p class="text-price">{{ Helper::formatPrice($product->current_price) }}</p>
                        @endif

                        <!-- cart -->
                        <button type="button"
                            class="btn btn-primary radius-8 w-100 product-page-add-to-cart-btn add-to-cart-btn @if(!$isAvailable) disabled @endif"
                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                            data-price="{{ $product->current_price }}" data-quantity="1">
                            {{ __('main.add_to_cart') }}
                        </button>
                        <!-- end cart -->

                    </div>
                    <div class="product-details">
                        <div class="btn-items">
                            <div class="btn-item">
                                <button type="button"
                                    class="btn btn-primary radius-8 add-to-cart-btn @if(!$isAvailable) disabled @endif"
                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                    data-price="{{ $product->current_price }}" data-quantity="1" data-checkout-url="{{ route('cart.checkout', ['gift' => 1]) }}">
                                    <svg width="16" height="16" fill="#fcb300">
                                        <use xlink:href="#gift-box"></use>
                                    </svg>
                                    {{ __('main.make_a_gift2') }}
                                </button>
                            </div>
                            <div class="btn-item">
                                <button type="button"
                                    class="btn btn-primary radius-8 add-to-cart-btn @if(!$isAvailable) disabled @endif"
                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                    data-price="{{ $product->current_price }}" data-quantity="1" data-checkout-url="{{ route('cart.checkout') }}">
                                    {{ __('main.buy_in_one_click') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="take-methods radius-8">
                        <ul class="take-methods__list">
                            <li>
                                <svg width="36" height="36" fill="#fcb300">
                                    <use xlink:href="#delivery"></use>
                                </svg>
                                <div>{!! $freeDeliveryText !!}</div>
                            </li>
                            <li>
                                <svg width="36" height="36" fill="#fcb300">
                                    <use xlink:href="#box"></use>
                                </svg>
                                <div>{!! $receiveMethodsText !!}</div>
                            </li>
                        </ul>
                    </div>
                    <div class="payment-methods radius-8">
                        <ul class="payment-methods__list">
                            <li>
                                <img src="{{ asset('img/logos/payme.jpg') }}" alt="">
                            </li>
                            <li>
                                <img src="{{ asset('img/logos/click.jpg') }}" alt="">
                            </li>
                            <li>
                                <img src="{{ asset('img/logos/uzcard.jpg') }}" alt="">
                            </li>
                            <li>
                                <img src="{{ asset('img/logos/humo.jpg') }}" alt="">
                            </li>
                        </ul>
                    </div>
                    @if ($paymentStaticPage)
                        <a href="{{ $paymentStaticPage->url }}" class="ml-auto">{{ __('main.payment_methods') }}</a>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <section class="product-descr" id="product-descr-container">
        <div class="container">
            <div class="product-descr__wrap">
                <ul class="product-descr__nav nav d-none d-lg-flex">
                    <li>
                        <a href="#product-description" data-toggle="tab">{{ __('main.description') }}</a>
                    </li>
                    <li>
                        <a href="#product-characteristics" class="active" data-toggle="tab">{{ __('main.specifications') }}</a>
                    </li>
                    <li>
                        <a href="#tab-3" data-toggle="tab">{{ __('main.delivery') }}</a>
                    </li>
                    <li>
                        <a href="#tab-4" data-toggle="tab">{{ __('main.guarantee') }}</a>
                    </li>
                    <li>
                        <a href="#tab-5" data-toggle="tab">{{ __('main.payment') }}</a>
                    </li>
                    <li>
                        <a href="#tab-6" data-toggle="tab">
                            <span class="badge">{{ $reviewsQuantity }}</span>
                            {{ __('main.reviews') }}
                        </a>
                    </li>
                </ul>
                <div class="product-descr__content tab-content d-none d-lg-block">
                    <div class="tab-pane" id="product-description">
                        <div data-target="more-container">
                            <div class="text-block">
                                {!! $product->body ?: Helper::seo('product', 'body', $seoReplacements) !!}
                            </div>
                        </div>
                        <a href="javascript:;" data-toggle="more-btn">{{ __('main.show_full') }}</a>
                    </div>
                    <div class="tab-pane active" id="product-characteristics">

                        <div class="row">
                            @if (!$attributes->isEmpty())
                            @php
                                $chunkSize = ceil($attributes->count() / 2);
                                $attributeChunks = $attributes->chunk($chunkSize);
                            @endphp
                            @foreach ($attributeChunks as $attributeChunk)
                            <div class="col-lg-5">
                                <div class="product-characters">
                                    <ul class="product-characters__list">
                                        @foreach ($attributeChunk as $attribute)
                                        <li>
                                            <span>{{ $attribute->name }}</span>
                                            <div class="col"></div>
                                            <strong>
                                                @foreach ($attribute->attributeValues as $attributeValue)
                                                {{ $attributeValue->name }}@if (!$loop->last){{ ',' }}@endif
                                                @endforeach
                                            </strong>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
                            @endforeach
                            @endif
                        </div>

                        @if (trim($product->specifications))
                        <div class="text-block mt-4">
                            {!! $product->specifications !!}
                        </div>
                        @endif

                    </div>
                    <div class="tab-pane" id="tab-3">
                        <div class="text-block">
                            {!! $deliveryText !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-4">
                        <div class="text-block">
                            {!! $guaranteeText !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-5">
                        <div class="text-block">
                            {!! $paymentText !!}
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-6">
                        @include('partials.reviews', ['reviewable_id' => $product->id, 'reviewable_type' => 'product'])
                    </div>
                </div>

                <div class="product-descr-m d-lg-none">
                    <h3>{{ __('main.description') }}</h3>
                    <div class="text-block mb-4">
                        {!! $product->body !!}
                    </div>

                    @if (!$attributes->isEmpty())
                    <h3>{{ __('main.specifications') }}</h3>
                    <ul class="product-descr-m__list" data-target="more-container">
                        @if($brand)
                        <li>
                            <span>{{ __('main.brand') }}</span>
                            <div class="col"></div>
                            <strong>{{ $brand->name }}</strong>
                        </li>
                        @endif
                        @foreach ($attributes as $attribute)
                        <li>
                            <span>{{ $attribute->name }}</span>
                            <div class="col"></div>
                            <strong>
                                @foreach ($attribute->attributeValues as $attributeValue)
                                {{ $attributeValue->name }}@if (!$loop->last){{ ',' }}@endif
                                @endforeach
                            </strong>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    @if ($attributes->count() > 6)
                    <a href="javascript:;" data-toggle="more-btn">
                        <svg width="14" height="14" fill="#fcb300">
                            <use xlink:href="#arrow"></use>
                        </svg>
                        <span>{{ __('main.all_specifications') }}</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

