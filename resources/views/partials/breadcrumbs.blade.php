@if(!empty($breadcrumbs))
<ul class="breadcrumb">
    @foreach($breadcrumbs->getItems() as $link)
        @if($link->isActive())
            <li>
                <a href="{{ $link->url }}">{{ $link->name }}</a>
            </li>
        @else
            <li class="active" aria-current="page">
                {{ $link->name }}
            </li>
        @endif
    @endforeach
</ul>
@endif
