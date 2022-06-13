<div class="item">
    <div class="thumb">
        <a href="{{ $employee->url }}" class="d-block">
            <img src="{{ $employee->medium_img }}" alt="{{ $employee->full_name }}" class="img-fluid rounded-circle">
        </a>
    </div>
    <div class="info">
        <div class="content">
            <h4><a href="{{ $employee->url }}" class="text-secondary">{{ $employee->full_name }}</a></h4>
            <span class="text-green2">{{ $employee->getTranslatedAttribute('position') }}</span>
        </div>
    </div>
</div>
