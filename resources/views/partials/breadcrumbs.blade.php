@if(!empty($breadcrumbs))
<ul class="breadcrumb">
    @foreach($breadcrumbs->getItems() as $key => $link)
        @if($link->isActive())
            <li @if($key == 0) style="padding-left: 0" @endif>
                <a href="{{ $link->url }}">{{ $link->name }}</a>
            </li>
        @else
            <li class="active" aria-current="page" @if($key == 0) style="padding-left: 0" @endif>
                {{ $link->name }}
            </li>
        @endif
    @endforeach
</ul>
@endif
