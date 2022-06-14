<div class="form-box">
    <form action="{{ route('cvs.store') }}" method="POST" class="cv-form" enctype="multipart/form-data">
        @csrf

        @if (isset($cv_id))
            <input type="hidden" name="cv_id" value="{{ $cv_id }}">
        @endif

        <div class="form-result"></div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input class="form-control form-control-primary" name="name" placeholder="{{ __('main.form.your_name') }}" type="text" required>
                    <span class="alert-error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <input class="form-control form-control-primary" name="email" placeholder="{{ __('main.email') }}" type="email" required>
                    <span class="alert-error"></span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <input class="form-control form-control-primary" name="phone_number" placeholder="{{ __('main.phone_number') }}" type="text" required>
                    <span class="alert-error"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group comments">
                    <textarea class="form-control form-control-primary" name="message" placeholder="{{ __('main.message') }}" required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label class="d-block text-black font-weight-semibold">{{ __('main.cv_pdf_or_docs') }}</label>
                    <input type="file" name="file" class="border-0" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-md effect btn-primary">
                    {{ __('main.to_send') }}
                </button>
            </div>
        </div>
    </form>
</div>
