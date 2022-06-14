@extends('layouts.app')

@section('seo_title', $publication->getTranslatedAttribute('seo_title') ?: $publication->getTranslatedAttribute('name'))
@section('meta_description', $publication->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $publication->getTranslatedAttribute('meta_keywords'))
{{-- @section('body_class', 'no-sidebar-page') --}}

@section('content')

@include('partials.page_top', ['title' => $publication->getTranslatedAttribute('name')])

<div class="blog-area single full-blog full-blog py-5 position-relative">
    <div class="container">
        <div class="blog-items">
            <div class="row">
                <div class="blog-content wow fadeInUp col-lg-10 offset-lg-1 col-md-12">
                    <div class="item">

                        <div class="blog-item-box">

                            <div class="thumb">
                                @if($publication->image)
                                    <img src="{{ $publication->img }}" class="img-fluid" alt="{{ $publication->getTranslatedAttribute('name') }}">
                                @endif

                                <div class="date">{{ Helper::formatDate($publication->created_at, true) }}</div>
                            </div>

                            {{-- @if($publication->video_code)
                            <div class="fit-big-videos mb-4">
                                {!! $publication->video_code !!}
                            </div>
                            @endif
                            @if($publication->file)
                                <div class="pb-4">
                                    <a href="{{ Helper::getFileUrl($publication->file) }}" class="text-dark" download="{{ Helper::getFileOriginalName($publication->file) }}">{{ __('main.to_download') }} {{ $publication->file_name }}</a>
                                </div>
                            @endif
                            --}}

                            <div class="info">
                                {!! $publication->getTranslatedAttribute('body') !!}

                                <div class="mt-4">
                                    <h5 class="mb-2">{{ __('main.to_share') }}</h5>
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Start Post Pagination -->
                    <div class="post-pagi-area">
                        @if ($prev)
                        <a href="{{ $prev->url }}" class="text-left">
                            <i class="fas fa-angle-double-left d-none d-lg-inline-block"></i> {{ __('main.previous_news') }}
                            <h5 class="text-dark d-none d-lg-block">{{ $prev->getTranslatedAttribute('name') }}</h5>
                        </a>
                        @else
                        <span></span>
                        @endif

                        @if ($next)
                        <a href="{{ $next->url }}" class="text-right">
                            {{ __('main.next_news') }} <i class="fas fa-angle-double-right d-none d-lg-inline-block"></i>
                            <h5 class="text-dark d-none d-lg-block">{{ $next->getTranslatedAttribute('name') }}</h5>
                        </a>
                        @else
                        <span></span>
                        @endif
                    </div>
                    <!-- End Post Pagination -->

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
{!! setting('site.share_buttons_code') !!}
@endsection
