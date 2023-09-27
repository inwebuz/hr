<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h1 class="text-secondary">{{ $title ?? '' }}</h1>
                @include('partials.breadcrumbs', ['left' => 1])
                @if (!empty($description))
                    <p class="mt-4 mb-0">{{ $description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
