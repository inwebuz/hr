@extends('layouts.app')

@section('seo_title', $vacancyCategory->getTranslatedAttribute('seo_title') ?: $vacancyCategory->getTranslatedAttribute('name'))
@section('meta_description', $vacancyCategory->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $vacancyCategory->getTranslatedAttribute('meta_keywords'))

@section('content')

    @include('partials.page_top', ['title' => $vacancyCategory->getTranslatedAttribute('name')])

    <div class="faq-content-area position-relative pt-4 pb-5">
        <div class="container">

            @if (!$vacancyCategory->children->isEmpty())
                <div class="row align-center">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="p-4 border bg-light mb-4">
                            <div class="row">
                                @foreach ($vacancyCategory->children as $child)
                                    <div class="col-lg-3 col-sm-6 my-1">
                                        <a href="{{ $child->url }}" class="text-dark">{{ $child->getTranslatedAttribute('name') }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="faq-items">
                <div class="row align-center">

                    <div class="col-lg-10 offset-lg-1">
                        <div class="faq-content wow fadeInUp">
                            <div class="accordion" id="vacancy-accordion">
                                @foreach ($vacancies as $vacancy)
                                    <div class="card">
                                        <div class="card-header" id="vacancy-heading-{{ $vacancy->id }}">
                                            <h4 class="mb-0 collapsed" data-toggle="collapse" data-target="#vacancy-collapse-{{ $vacancy->id }}" aria-expanded="false"
                                                aria-controls="vacancy-collapse-{{ $vacancy->id }}">{{ $vacancy->getTranslatedAttribute('name') }}</h4>
                                        </div>
                                        <div id="vacancy-collapse-{{ $vacancy->id }}" class="collapse" aria-labelledby="vacancy-heading-{{ $vacancy->id }}" data-parent="#vacancy-accordion">
                                            <div class="card-body">
                                                <p>{{ $vacancy->getTranslatedAttribute('description') }}</p>
                                                <div class="text-block">
                                                    {!! $vacancy->getTranslatedAttribute('body') !!}
                                                </div>
                                                <div class="text-block mt-5">
                                                    <h4>{{ __('main.send_cv_form_title') }}</h4>
                                                </div>
                                                @include('partials.cv_form', ['vacancy_id' => $vacancy->id])
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
