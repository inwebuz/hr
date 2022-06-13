<div class="new-partners-area default-padding-bottom py-5">
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
</div>
