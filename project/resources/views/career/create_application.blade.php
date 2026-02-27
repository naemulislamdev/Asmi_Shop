@extends('layouts.front')
<style>
    label {
        margin: 0 !important;
        font-size: 15px !important;
    }

    .toast {
        background-color: #28a745 !important;
        color: #fff !important;
        border: none;
    }

    .toast-body {
        background-color: transparent !important;
    }

    /* From Uiverse.io by adamgiebl */
    button {
        position: relative;
        overflow: hidden;
    }

    .svg-wrapper {
        transition: transform 0.8s ease, opacity 0.8s ease;
    }

    button {
        position: relative;
        overflow: hidden;
    }

    .svg-wrapper {
        transition: transform 0.8s ease, opacity 0.8s ease;
    }

    /* submit click / focus */
    button:active .svg-wrapper,
    button:focus .svg-wrapper {
        transform: translate(220px, -160px) rotate(45deg) scale(1.2);
        opacity: 0;
    }

    /* click press effect */
    button:active {
        transform: scale(0.95);
    }

    /* সব states এর জন্য background + text color */
    button.btn,
    button.btn:active,
    button.btn:focus,
    button.btn:visited,
    button.btn:hover {
        background-color: #198754 !important;
        /* Green */
        color: #fff !important;
        /* White text */
        border-color: #198754 !important;
        /* Green border */
        outline: none;
        /* Focus outline remove */
        box-shadow: none;
        /* Focus shadow remove */
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    /* Plane animation – independent */
    button:active .svg-wrapper,
    button:focus .svg-wrapper {
        transform: translate(220px, -160px) rotate(45deg) scale(1.2);
        opacity: 0;
        transition: transform 15ms cubic-bezier(.22, .61, .36, 1), opacity 0.8s;
    }

    /* Click press effect */
    button:active {
        transform: scale(0.95);
    }

    @media(max-width: 768px) {
        .form-check-inline {
            display: block !important;
            margin-bottom: 10px;
        }
    }
</style>

@section('content')
    <section class="gs-breadcrumb-section bg-class" style="background: #1bb9cb; padding: 0;">
        <div class="container">
            <div class="row justify-content-center content-wrapper">
                <div class="col-12">
                    <h2 class="breadcrumb-title">@lang('Job Application Form')</h2>
                    <ul class="bread-menu">
                        <li><a class="text-white" href="{{ route('front.index') }}">@lang('Home')</a></li>
                        <li><a class="text-white" href="{{ route('front.career') }}">@lang('Career')</a></li>
                        <li class="text-white">@lang($career->title)</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="gs-career-section my-3">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0">Apply For {{ $career->title ?? 'Position' }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('front.career.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Full Name -->
                                <div class="form-group mb-2">
                                    <label for="full_name">Full Name <span class="text-danger">*</span></label>

                                    <input type="text" name="full_name" id="full_name"
                                        class="form-control @error('full_name') is-invalid @enderror"
                                        placeholder="Enter your full name" value="{{ old('full_name') }}">

                                    @error('full_name')
                                        <small class="text-danger">{{ ucwords($message) }}</small>
                                    @enderror
                                </div>


                                <!-- Email -->
                                <div class="form-group mb-2">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('value') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter your email">
                                    @error('email')
                                        <small class="text-danger">{{ ucwords($message) }}</small>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group mb-2">
                                    <label for="phone">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Enter your phone number" value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="text-danger">{{ ucwords($message) }}</small>
                                    @enderror
                                </div>

                                <!-- Position (Hidden or Readonly) -->
                                <div class="form-group mb-2">
                                    <label for="position">Position </label>
                                    <input type="text" name="position" id="position" class="form-control"
                                        value="{{ $career->title ?? '' }}" readonly>
                                </div>

                                <!-- CV Upload -->
                                <div class="form-group mb-2">

                                    <label for="cv">Upload CV <span class="text-danger">*</span><small
                                            class="form-text text-muted" style="font-size: 12px">(Allowed formats: PDF, DOC,
                                            DOCX)</small></label>
                                    <input type="file" name="cv" id="cv"
                                        class="form-control  @error('cv') is-invalid @enderror" accept=".pdf,.doc,.docx">
                                    @error('cv')
                                        <small class="text-danger">{{ ucwords($message) }}</small>
                                    @enderror
                                </div>

                                <!-- Experience -->
                                <div class="form-group mb-3">
                                    <label style="margin-bottom: 10px" class="d-block">Experience Level<span
                                            class="text-danger">*</span></label>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="experience" id="exp_fresher"
                                            value="Fresher">
                                        <label class="form-check-label" for="exp_fresher">Fresher</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="experience" id="exp_06_1"
                                            value="0.6-1 years">
                                        <label class="form-check-label" for="exp_06_1">0.6 - 1 years</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="experience" id="exp_12"
                                            value="1-2 years">
                                        <label class="form-check-label" for="exp_12">1 - 2 years</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="experience" id="exp_23"
                                            value="2-3 years">
                                        <label class="form-check-label" for="exp_23">2 - 3 years</label>
                                    </div>

                                    @error('experience')
                                        <br>
                                        <small class="text-danger">{{ ucwords($message) }}</small>
                                    @enderror
                                </div>


                                <!-- Portfolio -->
                                <div class="form-group mb-2">
                                    <label for="portfolio">Portfolio <small
                                            style="font-size: 12px">(Optional)</small></label>
                                    <input type="url" name="portfolio" id="portfolio" class="form-control"
                                        placeholder="Your portfolio website link">
                                </div>

                                <!-- Submit Button -->
                                <div class="text-right mt-5 text-center">

                                    <!-- From Uiverse.io by adamgiebl -->
                                    <button type="submit" class="btn btn-success">
                                        <div class="svg-wrapper-1 d-flex align-items-center">
                                            <span>Submit Application</span>

                                            <div class="svg-wrapper">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    width="24" height="24">
                                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                                    <path fill="currentColor"
                                                        d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const plane = btn.querySelector('.svg-wrapper');

            btn.classList.add('hide-text');
            plane.classList.add('fly-out');

            // prevent double click
            btn.disabled = true;
        });
    </script>
@endpush
