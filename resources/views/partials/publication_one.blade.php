{{-- <a href="{{ $publication->url }}" class="article-item">
    <div class="article-item__body radius-6">
        <img src="{{ $publication->medium_img }}" alt="{{ $publication->name }}" class="img-fluid">
    </div>
    <div class="article-item__footer">
        <strong>{{ $publication->name }}</strong>
    </div>
</a> --}}

<div class="news-item radius-10">
    <span class="news-item__date">{{ Helper::formatDate($publication->created_at) }}</span>
    <a href="{{ $publication->url }}" class="news-item__link">{{ $publication->getTranslatedAttribute('name') }}</a>
    <p class="text-overflow-four-line">{{ $publication->getTranslatedAttribute('description') }}</p>
</div>
