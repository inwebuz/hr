<div class="breadcrumb-area text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="text-secondary">{{ $title ?? '' }}</h1>
                @include('partials.breadcrumbs')
                @if (!empty($description))
                    <p class="mt-4 mb-0">{{ $description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
