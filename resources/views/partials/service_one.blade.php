<div class="item rounded-lg" style="background-image: url({{ $service->medium_img }});">
    <div class="info">
        <div class="svg-icon">
            {!! $service->icon !!}
        </div>
        <h4><a href="{{ $service->url }}">{{ $service->getTranslatedAttribute('name') }}</a></h4>
        {{-- <p>{{ $service->getTranslatedAttribute('description') }}</p> --}}
        <div class="bottom mt-5">
            <a href="{{ $service->url }}"><i class="fas fa-arrow-right"></i> {{ __('main.view_more') }}</a>
        </div>
    </div>
</div>
