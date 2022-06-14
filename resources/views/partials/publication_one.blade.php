{{-- <a href="{{ $publication->url }}" class="article-item">
    <div class="article-item__body radius-6">
        <img src="{{ $publication->medium_img }}" alt="{{ $publication->name }}" class="img-fluid">
    </div>
    <div class="article-item__footer">
        <strong>{{ $publication->name }}</strong>
    </div>
</a> --}}

<div class="item">
    <div class="thumb">
        <a href="{{ $publication->url }}" class="d-block">
            <img src="{{ $publication->medium_img }}" class="img-fluid" alt="{{ $publication->getTranslatedAttribute('name') }}">
        </a>
        <div class="date">{{ Helper::formatDate($publication->created_at, true) }}</div>
    </div>
    <div class="info">
        <h4>
            <a href="{{ $publication->url }}">{{ $publication->getTranslatedAttribute('name') }}</a>
        </h4>
        <p>{{ $publication->getTranslatedAttribute('description') }}</p>
    </div>
</div>
