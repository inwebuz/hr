@extends('layouts.app')

@section('seo_title', $employee->getTranslatedAttribute('seo_title') ?: $employee->full_name)
@section('meta_description', $employee->getTranslatedAttribute('meta_description'))
@section('meta_keywords', $employee->getTranslatedAttribute('meta_keywords'))

@section('content')

<!-- Start Team Single Area
============================================= -->
<div class="team-single-area default-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 left-info">
                <div class="thumb">
                    <img src="{{ $employee->large_img }}" alt="{{ $employee->full_name }}" class="img-fluid rounded-circle border-gray-15">
                </div>
            </div>
            <div class="col-lg-7 right-info">
                <h2 class="mt-5 font-weight-bold text-secondary">{{ $employee->full_name }}</h2>
                <h4 class="font-weight-semibold text-green2">{{ $employee->getTranslatedAttribute('position') }}</h4>
                <p><em>{{ $employee->getTranslatedAttribute('description') }}</em></p>

                <hr class="my-3">

                <div class="text-block">
                    {!! $employee->getTranslatedAttribute('body') !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Team Single Area -->

@if (!$otherEmployees->isEmpty())
    <!-- Start Team Area
============================================= -->
<div class="team-area py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="site-heading text-center">
                    <h2>{{ $otherEmployeesText->getTranslatedAttribute('name') }}</h2>
                    <p>{{ $otherEmployeesText->getTranslatedAttribute('description') }}</p>
                </div>
            </div>
        </div>
        <div class="team-items text-center">
            <div class="row">
                @foreach ($otherEmployees as $otherEmployee)
                <div class="single-item col-lg-4 col-md-6">
                    @include('partials.employee_one', ['employee' => $otherEmployee])
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- End Team Area -->
@endif

@endsection
