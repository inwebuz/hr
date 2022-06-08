@if (!$publications->isEmpty())
<section class="news">
    <div class="container">
        <div class="content-top">
            <h2>{{ __('main.news') }}</h2>
            <a href="{{ route('news') }}" class="more-link" data-mobile-text="{{ __('main.all') }}">
                <span>{{ __('main.all') }}</span>
                <svg width="18" height="18" fill="#6b7279">
                    <use xlink:href="#arrow"></use>
                </svg>
            </a>
        </div>
        <div class="row news-wrap">
            @foreach ($publications as $publication)
            <div class="col-lg-4 col-md-6 news-item__parent">
                @include('partials.publication_one')
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
