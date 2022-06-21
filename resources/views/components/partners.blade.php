{{-- <div class="new-partners-area default-padding-bottom py-5">
    <div class="container">
        @php
            $partnersChunks = $partners->chunk(2);
        @endphp
        <div class="owl-carousel owl-theme new-partners-slider">
            @foreach ($partnersChunks as $partnersChunk)
                <div class="new-partner-single text-center">
                    @foreach ($partnersChunk as $partner)
                        <a href="{{ $partner->url }}" class="d-block">
                            <img src="{{ $partner->medium_img }}" alt="{{ $partner->getTranslatedAttribute('name') }}" class="img-fluid">
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div> --}}

<div class="new-partners-area default-padding">
    <div class="container">
        <div class="site-heading text-center mb-4">
            <h2>{{ $page->getTranslatedAttribute('name') }}</h2>
            <p>{{ $page->getTranslatedAttribute('description') }}</p>
        </div>
        <div class="owl-carousel owl-theme new-partners-slider">
            @foreach ($partners as $partner)
                <div class="new-partner-single text-center">
                    <a href="{{ $partner->url }}" class="d-block">
                        <img src="{{ $partner->medium_img }}" alt="{{ $partner->getTranslatedAttribute('name') }}" class="img-fluid">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
