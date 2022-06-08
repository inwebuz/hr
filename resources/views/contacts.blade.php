@extends('layouts.app')

@section('seo_title', $page->getTranslatedAttribute('seo_title') ?: $page->getTranslatedAttribute('name'))
@section('meta_description', $page->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $page->getTranslatedAttribute('meta_keywords'))

@php
    $phone = setting('contact.phone');
    $phone2 = setting('contact.phone2');
    $email = setting('contact.email');
@endphp

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    <div class="container py-4 py-lg-5">

        <h1>{{ $page->getTranslatedAttribute('name') }}</h1>

        <div class="row mb-5">
            <div class="col-lg-6 order-lg-2 mb-5 mb-lg-0">

                <h3 class="contact-title mb-4">{{ __('main.our_contacts') }}</h3>

                <div class="media contact-info mb-3">
                    {{-- <i class="fa fa-map-marker mr-3 mt-1"></i> --}}
                    <div class="media-body">
                        <span>{{ $address }}</span>
                    </div>
                </div>
                <div class="media contact-info mb-3">
                    {{-- <i class="fa fa-phone mr-3 mt-1"></i> --}}
                    <div class="media-body">
                        <span><a href="tel:{{ Helper::phone($phone) }}" class="black-link">{{ $phone }}</a></span>
                        @if ($phone2)
                            <br>
                            <span><a href="tel:{{ Helper::phone($phone2) }}" class="black-link">{{ $phone2 }}</a></span>
                        @endif
                    </div>
                </div>
                <div class="media contact-info mb-3">
                    {{-- <i class="fa fa-envelope mr-3 mt-1"></i> --}}
                    <div class="media-body">
                        <span><a href="mailto:{{ $email }}" class="black-link">{{ $email }}</a></span>
                    </div>
                </div>

                <div class="contact-map my-4">
                    {!! setting('contact.map') !!}
                </div>

            </div>
            <div class="col-lg-6 order-lg-1">

                <h3 class="contact-title">{{ __('main.write_us') }}</h3>

                <form class="contact-form" method="post"  action="{{ route('contacts.send') }}">

                    @csrf

                    <div class="form-result"></div>

                    <div class="form-group">
                        <label for="form_name">{{ __('main.form.your_name') }}&nbsp;<span class="text-danger">*</span></label>
                        <input class="form-control" name="name" id="form_name" type="text" required>
                    </div>

                    <div class="form-group">
                        <label for="form_phone">{{ __('main.form.phone') }}&nbsp;<span class="text-danger">*</span></label>
                        <input class="form-control" name="phone" id="form_phone" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="form_message">{{ __('main.form.message') }}</label>
                        <textarea class="form-control" name="message" id="form_message" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="form_security_code">{{ __('main.form.security_code') }}</label>
                        <div class="row gutters-5">
                            <div class="col-lg-6 mb-3 mb-lg-0">
                                <input type="text" name="captcha" class="form-control" id="form_security_code" placeholder="{{ __('main.form.security_code') }}" required>
                            </div>
                            <div class="col-lg-6">
                                <div class="captcha-container">
                                    <img src="{{ asset('images/captcha.png') }}" alt="Captcha" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary radius-6">{{ __('main.form.send') }}</button>
                    </div>
                </form>
            </div>
        </div>

        @if ($page->getTranslatedAttribute('body'))
            <div class="text-block my-5">
                {!! $page->getTranslatedAttribute('body') !!}
            </div>
        @endif

    </div>

</main>

@endsection
