@php
$phone = Helper::setting('contact.phone', 5);
$email = Helper::setting('contact.email', 5);
$siteTitle = Helper::setting('site.title', 5);
@endphp
{{-- @if (auth()->check() &&
    auth()->user()->isAdmin())
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
        <form action="{{ route('search') }}" class="top-search">
            <div class="container">
                <div class="input-group">
                    <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
                    <input type="text" class="form-control" name="q" placeholder="{{ __('main.search') }}">
                    <span class="input-group-addon"><button class="btn btn-link" type="submit"><i class="fa fa-search text-light"></i></button></span>
                </div>
            </div>
        </form>
        <!-- End Top Search -->

        <div class="container">

            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="search mr-3"><a href="javascript:;"><i class="ti-search"></i></a></li>
                    @foreach ($switcher->getValues() as $key => $item)
                        <li>
                            <a href="{{ $item->url }}" class="px-1 text-uppercase @if ($item->key == $switcher->getActive()->key) active text-primary font-weight-bold @endif">{{ $item->key }}</a>
                        </li>
                    @endforeach
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

                    @foreach ($headerMenuItems as $item)
                        @if ($item->hasItems())
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{ $item->name }}</a>
                                <ul class="dropdown-menu @if($item->url == route('vacancies.index')) dropdown-menu-2-column @endif">
                                    @foreach ($item->getItems() as $subItem)
                                        <li>
                                            <a href="{{ $subItem->url }}" class="d-block">{{ $subItem->name }}</a>
                                            @if ($subItem->hasItems())
                                                <ul class="list-unstyled">
                                                    @foreach ($subItem->getItems() as $subChildItem)
                                                        <li>
                                                            <a href="{{ $subChildItem->url }}" class="py-2 py-lg-1 px-4 font-weight-normal d-block">- {{ $subChildItem->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ $item->url }}">{{ $item->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>

    </nav>
    <!-- End Navigation -->

</header>
