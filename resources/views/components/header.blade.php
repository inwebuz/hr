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

<div class="header-d d-none d-lg-block">
    <div class="header-d-top">
        <div class="container">
            <div class="header-d-top__wrap">
                <div class="dropdown dropdown-lang">
                    <a href="javascript:;" class="dropdown-toggle text-gray" data-toggle="dropdown">
                        <img src="{{ asset('img/icons/flag_' . $switcher->getActive()->key . '.jpg') }}" alt="{{ $switcher->getActive()->name }}">
                        <span>{{ $switcher->getActive()->name }}</span>
                        <svg class="arrow" width="12" height="12" fill="#666">
                            <use xlink:href="#arrow-down"></use>
                        </svg>
                    </a>
                    <div class="dropdown-menu">
                        @foreach ($switcher->getValues() as $item)
                            <a href="{{ $item->url }}" class="dropdown-item @if($switcher->getActive()->key == $item->key) active @endif" >
                                <img src="{{ asset('img/icons/flag_' . $item->key . '.jpg') }}" alt="{{ $item->name }}">
                                <span>{{ $item->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <ul class="header-d-top__list">
                    @foreach ($headerMenuItems as $item)
                        <li>
                            <a href="{{ $item->url }}">
                                <span>{{ $item->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <ul class="header-d-top__list">
                    <li>
                        <a href="mailto:{{ $email }}">
                            <span>{{ $email }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="tel:{{ Helper::phone($phone) }}">
                            <span>{{ $phone }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="header-d-bottom">
        <div class="container">
            <div class="header-d-bottom__wrap">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ $logo }}" alt="{{ $siteTitle }}">
                    </a>
                </div>
                <a href="#" class="btn btn-primary sm radius-4 font-bold" data-toggle="catalog-menu-d">
                    <svg width="22" height="22" fill="#fff">
                        <use xlink:href="#list"></use>
                    </svg>
                    <span>{{ __('main.nav.catalog') }}</span>
                </a>
                <form class="search-field radius-6 ajax-search-form ajax-search-container" action="{{ route('search') }}">
                    <label>
                        <input type="text" class="input-field-search ajax-search-input" name="q" placeholder="{{ __('main.i_want_to_buy') }} …">
                    </label>
                    <button type="submit" class="btn btn-primary sm search-btn">
                        <svg width="24" height="24" stroke="#fff">
                            <use xlink:href="#search"></use>
                        </svg>
                    </button>
                    <div class="ajax-search-results">
                        <div class="ajax-search-results-content py-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-4 border-right">
                                        <div class="products-list-group list-group"></div>
                                    </div>
                                    <div class="col-lg-4 border-right">
                                        <div class="categories-list-group list-group"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="brands-list-group list-group"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="header-d-nav__list">
                    <li>
                        <a href="{{ route('wishlist.index') }}">
                            <span class="badge wishlist_count">{{ $wishlistQuantity }}</span>
                            <svg width="24" height="24" fill="#333">
                                <use xlink:href="#heart"></use>
                            </svg>
                            <span>{{ __('main.featured') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}">
                            <span class="badge cart_count">{{ $cartQuantity }}</span>
                            <svg width="24" height="24" fill="#333">
                                <use xlink:href="#cart"></use>
                            </svg>
                            <span>{{ __('main.cart') }}</span>
                        </a>
                    </li>
                    <li>
                        @guest
                        <a href="{{ route('login') }}">
                            <svg width="24" height="24" fill="#333">
                                <use xlink:href="#user"></use>
                            </svg>
                            <span>{{ __('main.login') }}</span>
                        </a>
                        @else
                        <a href="{{ route('profile.show') }}">
                            <svg width="24" height="24" fill="#333">
                                <use xlink:href="#user"></use>
                            </svg>
                            <span>{{ __('main.profile') }}</span>
                        </a>
                        @endguest
                    </li>
                </ul>
            </div>
            <ul class="header-d-bottom__list">
                @foreach ($menuCategories as $item)
                <li>
                    <a href="{{ $item->getTranslatedAttribute('url') }}">{{ $item->getTranslatedAttribute('title') }}</a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="catalog-menu-d">
            <div class="container">
                <div class="row catalog-menu-d__wrap">
                    <div class="col-lg-20">
                        <ul class="catalog-menu-d__list">
                            @foreach ($menuCatalog as $key => $category)
                                <li>
                                    <a href="{{ $category->url }}" class="radius-6 parent-category @if($key == 0) current @endif" data-category-id="{{ $category->id }}">
                                        <span class="category-svg-icon">
                                            {!! $category->svg_icon_img !!}
                                        </span>
                                        {{-- <img src="{{ $category->micro_icon_img }}" alt="{{ $category->getTranslatedAttribute('name') }}"> --}}
                                        {{ $category->getTranslatedAttribute('name') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-80">
                        @foreach ($menuCatalog as $key => $category)
                            <div class="catalog-menu-d__content-container @if($key == 0) active @endif"  data-category-id="{{ $category->id }}">
                                <div class="catalog-menu-d__content">
                                    @if (!$category->children->isEmpty())
                                        <div class="catalog-menu-d-nav__wrap">
                                            @foreach ($category->children as $child)
                                                <div class="catalog-menu-d-nav">
                                                    <a href="{{ $child->url }}">{{ $child->getTranslatedAttribute('name') }}</a>
                                                    @if (!$category->children->isEmpty())
                                                        <ul class="catalog-menu-d-nav__list">
                                                            @foreach ($child->children as $subchild)
                                                            <li>
                                                                <a href="{{ $subchild->url }}">{{ $subchild->getTranslatedAttribute('name') }}</a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header-m d-lg-none">
    <div class="header-m-top">
        <div class="container">
            <div class="header-m-top__wrap">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ $logo }}" alt="{{ $siteTitle }}">
                    </a>
                </div>
                <div class="contacts">
                    <a href="tel:{{ Helper::phone($phone) }}" class="phone-link">{{ $phone }}</a>
                    <div class="dropdown dropdown-lang">
                        <a href="javascript:;" class="dropdown-toggle text-gray" data-toggle="dropdown">
                            <span class="text-uppercase">{{ $switcher->getActive()->key }}</span>
                            <svg width="14" height="14" fill="#666">
                                <use xlink:href="#arrow-down"></use>
                            </svg>
                        </a>
                        <div class="dropdown-menu right">
                            @foreach ($switcher->getValues() as $item)
                            <a href="{{ $item->url }}" class="dropdown-item text-uppercase">{{ $item->key }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-m-bottom">
        <div class="container">
            <div class="header-m-bottom__wrap">
                <a href="#" class="btn-icon radius-4" data-toggle-menu="catalog-menu-m">
                    <svg width="22" height="22" fill="#fff">
                        <use xlink:href="#list"></use>
                    </svg>
                </a>
                <form class="search-field radius-4 ajax-search-form ajax-search-container" action="{{ route('search') }}">
                    <div class="input-group">
                        <input type="text" class="input-field-search form-control ajax-search-input" name="q" placeholder="{{ __('main.i_want_to_buy') }} …">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary radius-right-4">
                                <svg width="22" height="22" fill="#fff">
                                    <use xlink:href="#search"></use>
                                </svg>
                            </button>
                        </span>
                    </div>
                    <div class="ajax-search-results">
                        <div class="ajax-search-results-content py-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-4 border-bottom">
                                        <div class="products-list-group list-group"></div>
                                    </div>
                                    <div class="col-lg-4 border-bottom">
                                        <div class="categories-list-group list-group"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="brands-list-group list-group"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="catalog-menu-m" data-target-menu="catalog-menu-m">
    <div class="catalog-menu-m__header">
        <button type="button" data-toggle="menu-close">
            <span>&times;</span>
        </button>
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ $logo }}" alt="{{ $siteTitle }}" class="img-fluid">
            </a>
        </div>
    </div>
    <div class="catalog-menu-m__content">
        <div class="catalog-menu-m__body">
            <ul class="catalog-menu-m__list">
                @foreach ($menuCatalog as $category)
                    <li>
                        <a href="{{ $category->url }}">
                            <span class="category-svg-icon">
                                {!! $category->svg_icon_img !!}
                            </span>
                            <span>{{ $category->getTranslatedAttribute('name') }}</span>
                            @if (!$category->children->isEmpty())
                                <span class="show-subcategories-m" data-category-id="{{ $category->id }}">
                                    <svg width="16" height="16" fill="#999">
                                        <use xlink:href="#arrow"></use>
                                    </svg>
                                </span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@foreach ($menuCatalog as $category)
    @if (!$category->children->isEmpty())
        <div class="subcategories-m" data-category-id="{{ $category->id }}">
            <div class="catalog-menu-m__content">
                <div class="catalog-menu-m__body">
                    <ul class="catalog-menu-m__list">
                        <li>
                            <a href="javascript:;" class="close-subcategories-m" data-category-id="{{ $category->id }}">
                                <strong>
                                    &larr; {{ $category->getTranslatedAttribute('name') }}
                                </strong>
                            </a>
                        </li>
                        @foreach ($category->children as $subcategory)
                            <li>
                                <a href="{{ $subcategory->url }}" class="">
                                    <span>{{ $subcategory->getTranslatedAttribute('name') }}</span>
                                    @if (!$subcategory->children->isEmpty())
                                        <span class="show-subcategories-m" data-category-id="{{ $subcategory->id }}">
                                            <svg width="16" height="16" fill="#999">
                                                <use xlink:href="#arrow"></use>
                                            </svg>
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @foreach ($category->children as $subcategory)
            @if (!$subcategory->children->isEmpty())
                <div class="subcategories-m" data-category-id="{{ $subcategory->id }}">
                    <div class="catalog-menu-m__content">
                        <div class="catalog-menu-m__body">
                            <ul class="catalog-menu-m__list">
                                <li>
                                    <a href="javascript:;" class="close-subcategories-m" data-category-id="{{ $subcategory->id }}">
                                        <strong>
                                            &larr; {{ $subcategory->getTranslatedAttribute('name') }}
                                        </strong>
                                    </a>
                                </li>
                                @foreach ($subcategory->children as $subsubcategory)
                                    <li>
                                        <a href="{{ $subsubcategory->url }}" class="">
                                            <span>{{ $subsubcategory->getTranslatedAttribute('name') }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
@endforeach
