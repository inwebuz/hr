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

@include('partials.page_top', ['title' => $page->getTranslatedAttribute('name')])

<div class="contact-us-area py-5 position-relative">
    <div class="container">
        <div class="row align-center">
            <div class="col-lg-5 info">
                <div class="content">
                    <h2 class="font-weight-bold">{{ $ourContacts->getTranslatedAttribute('name') }}</h2>
                    <p>{{ $ourContacts->getTranslatedAttribute('description') }}</p>
                    <ul>
                        <li>
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="content">
                                <h5>{{ __('main.address') }}</h5>
                                <p>{{ $address }}</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="content">
                                <h5>{{ __('main.nav.contacts') }}</h5>
                                <p>
                                    @if ($phone)
                                        <a href="tel:{{ Helper::phone($phone) }}" class="text-dark">{{ $phone }}</a>
                                    @endif
                                    @if ($phone2)
                                        <br>
                                        <a href="tel:{{ Helper::phone($phone2) }}" class="text-dark">{{ $phone2 }}</a>
                                    @endif
                                    @if ($email)
                                        <br>
                                        <a href="mailto:{{ $email }}" class="text-primary">{{ $email }}</a>
                                    @endif
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7 contact-form-box">
                <div class="form-box">
                    <form class="contact-form" method="post"  action="{{ route('contacts.send') }}">

                        @csrf

                        <div class="form-result"></div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" name="name" placeholder="{{ __('main.form.your_name') }}" type="text" required>
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input class="form-control" name="phone" placeholder="{{ __('main.form.phone') }}" type="text" required>
                                    <span class="alert-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group comments">
                                    <textarea class="form-control" name="message" placeholder="{{ __('main.form.message') }}" required></textarea>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="form-group">
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
                        </div> --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-md effect btn-primary">{{ __('main.form.send') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- @if ($page->getTranslatedAttribute('body'))
            <div class="text-block mt-4">
                {!! $page->getTranslatedAttribute('body') !!}
            </div>
        @endif --}}
    </div>
</div>

<div class="maps-area">
    <div class="google-maps">
        {!! setting('contact.map') !!}
    </div>
</div>

@endsection
