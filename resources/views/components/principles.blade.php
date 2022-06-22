<div class="about-content-area default-padding">
    <div class="container">
        <div class="content-box">
            <div class="row">
                <div class="col-lg-4 thumb">
                    <div class="thumb-box">
                        <img src="{{ asset('assets/img/principles.jpg') }}" alt="">
                        <div class="shape" style="background-image: url({{ asset('assets/img/shape/1.png') }});"></div>
                    </div>
                </div>
                <div class="col-lg-8 info">
                    <h2 class="font-weight-bold">{{ __('main.company_principles') }}</h2>
                    <ul>
                        @foreach ($principles as $key => $principle)
                        <li class="d-flex align-items-center">
                            <div class="icon">
                                <span class="text-primary py-2 px-3 text-center mr-3 d-inline-block rounded-circle font-weight-bold bg-light">{{ $key + 1 }}</span>
                            </div>
                            <div class="info">
                                <p>{{ $principle->getTranslatedAttribute('description') }}</p>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
