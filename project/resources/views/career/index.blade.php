@extends('layouts.front')

<style>
    /* From Uiverse.io by adeladel522 */
    .button {
        position: relative;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        padding-block: 0.5rem;
        padding-inline: 1.25rem;
        background-color: rgb(0 107 179);
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #ffff;
        gap: 10px;
        font-weight: bold;
        border: 3px solid #ffffff4d;
        outline: none;
        overflow: hidden;
        font-size: 15px;
    }

    .icon {
        width: 24px;
        height: 24px;
        transition: all 0.3s ease-in-out;
    }

    .button:hover {
        transform: scale(1.05);
        border-color: #fff9;
    }

    .button:hover .icon {
        transform: translate(4px);
    }

    .button:hover::before {
        animation: shine 1.5s ease-out infinite;
    }

    .button::before {
        content: "";
        position: absolute;
        width: 100px;
        height: 100%;
        background-image: linear-gradient(120deg,
                rgba(255, 255, 255, 0) 30%,
                rgba(255, 255, 255, 0.8),
                rgba(255, 255, 255, 0) 70%);
        top: 0;
        left: -100px;
        opacity: 0.6;
    }

    @keyframes shine {
        0% {
            left: -100px;
        }

        60% {
            left: 100%;
        }

        to {
            left: 100%;
        }
    }
</style>
@section('content')
    <section class="gs-breadcrumb-section bg-class" style="background: #1bb9cb; padding: 0;">
        <div class="container">
            <div class="row justify-content-center content-wrapper">
                <div class="col-12">
                    <h2 class="breadcrumb-title">@lang('Career')</h2>
                    <ul class="bread-menu">
                        <li><a class="text-white" href="{{ route('front.index') }}">@lang('Home')</a></li>
                        <li class="text-white">@lang('Career')</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="gs-career-section my-3" style="min-height: 100vh">
        <div class="container-fluid">
            <div class="row">
                @if ($careers->count() > 0)
                    @foreach ($careers as $career)
                        <div class="col-md-12">
                            <div class="card mb-4 job-card"
                                style="box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px; border-radius: 15px">
                                <div class="row ">
                                    <!-- Image -->

                                    <div class=" @if ($career->image) col-lg-4 @else col-lg-8 @endif ">
                                        @if ($career->image)
                                            <div class="position-relative "
                                                style="z-index: 99999; height: 380px; overflow: hidden; width: auto;">
                                                <a href="{{ asset('assets/images/jobs/' . $career->image) }}"
                                                    class="glightbox" data-gallery="jobs">
                                                    <img style="max-height: 100%; width: auto"
                                                        src="{{ asset('assets/images/jobs/' . $career->image) }}"
                                                        class="card-img job-img" alt="Job Image">
                                                </a>
                                            </div>
                                        @else
                                            <div class="ps-3">
                                                {!! $career->description !!}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="@if ($career->description) col-lg-8 @else col-lg-4 @endif">
                                        <div class="@if ($career->description) ps-3 @endif">
                                            <div class="d-flex justify-content-between align-items-start mt-3 ">
                                                <div>
                                                    <h4 class="card-title mb-1 font-weight-bold">
                                                        {{ $career->title }}
                                                    </h4>
                                                    <p class="text-muted mb-1"><strong>Company Name:</strong> Asmi Supershop
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Job Info -->
                                            <div class="job-info d-flex flex-wrap mb-2">
                                                @if ($career->experience)
                                                    <span class="text-muted me-3"><i class="fas fa-briefcase"></i>
                                                        {{ $career->experience }}
                                                        Years</span>
                                                @endif
                                                @if ($career->job_location)
                                                    <span class="me-3 text-muted"><i class="fas fa-map-marker-alt"></i>
                                                        {{ $career->job_location }}</span>
                                                @endif

                                            </div>
                                        </div>
                                        <div
                                            class="card-body
                                            job-content p-0 @if ($career->description) ps-3 pb-3 @endif">

                                            <!-- Footer -->
                                            <div class="d-flex align-items-center mt-3">
                                                <div>
                                                    <a href="{{ route('front.career.details', $career->slug) }}"
                                                        class="btn btn-primary rounded-pill">
                                                        <i class="fa fa-eye"></i> View Details
                                                    </a>
                                                </div>
                                                <div class="ms-3">

                                                    <!-- From Uiverse.io by adeladel522 -->
                                                    <a href="{{ route('front.career.applyForm', $career->slug) }}"
                                                        class="button">
                                                        Apply Now
                                                        <svg fill="currentColor" viewBox="0 0 24 24" class="icon">
                                                            <path clip-rule="evenodd"
                                                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                                                                fill-rule="evenodd"></path>
                                                        </svg>
                                                    </a>

                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex align-items-center justify-content-center">
                        <h4>At this time, no job positions are available on our website.</h4>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
