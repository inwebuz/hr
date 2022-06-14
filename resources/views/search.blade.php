@extends('layouts.app')

@section('seo_title', __('main.nav.search'))
@section('meta_description', '')
@section('meta_keywords', '')

@section('content')

@include('partials.page_top', ['title' => __('main.search_results')])

<div class="py-5">
    <div class="container">
        <form action="{{ route('search') }}" class="search-form">

            <div class="input-group input-group-lg mb-4">
                <input type="text" name="q" class="form-control" placeholder="{{ __('main.search') }}" value="{{ $q }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        {{ __('main.search') }}
                    </button>
                </div>
            </div>

            @if(!$searches->isEmpty())

                <div class="">
                    @foreach ($searches as $search)
                        @if ($search->searchable)
                        <a href="{{ $search->searchable->url }}" class="d-block mb-4">
                            <h4 class="font-weight-bold mb-1 text-dark">{{ $search->searchable->getTranslatedAttribute('name') ?: $search->searchable->full_name }}</h4>
                            @if ($search->searchable->getTranslatedAttribute('description'))
                                <p class="text-gray">{{ $search->searchable->getTranslatedAttribute('description') }}</p>
                            @endif
                        </a>
                        @endif

                    @endforeach
                </div>

                <div class="mt-4">
                    {!! $links !!}
                </div>

            @else
                <div class="lead">
                    {{ __('main.nothing_found') }}
                </div>
            @endif
        </form>
    </div>
</div>


@endsection
