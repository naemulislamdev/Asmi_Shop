@extends('layouts.admin')

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('Career') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Jobs') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('career.jobs') }}">{{ __('Jobs') }} </a>
                        </li>
                        <li>
                            <span disabled>{{ __('Edit Job') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">
                        @include('alerts.admin.form-success')

                        <div class="position-relative">


                            <div class="container mt-4">

                                <!-- Back Button -->
                                <div class="mb-3 d-flex justify-content-start">
                                    <a href="" class="btn btn-primary btn-sm">← Back</a>
                                </div>

                                <!-- Job Details -->
                                <div class="row g-3">

                                    <!-- Job Title -->
                                    <div class="col-md-6 d-flex justify-content-between border-bottom py-2">
                                        <strong>Job Title:</strong>
                                        <span>{{ $job->title }}</span>
                                    </div>

                                    <!-- Department -->
                                    <div class="col-md-6 d-flex justify-content-between border-bottom py-2">
                                        <strong>Department:</strong>
                                        <span>{{ $job->department ?? 'N/A' }}</span>
                                    </div>

                                    <!-- Job Type -->
                                    <div class="col-md-6 d-flex justify-content-between border-bottom py-2">
                                        <strong>Job Type:</strong>
                                        <span>{{ $job->type ?? 'N/A' }}</span>
                                    </div>

                                    <!-- Location -->
                                    <div class="col-md-6 d-flex justify-content-between border-bottom py-2">
                                        <strong>Location:</strong>
                                        <span>{{ $job->job_location ?? 'N/A' }}</span>
                                    </div>

                                    <!-- Post Date -->
                                    <div class="col-md-6 d-flex justify-content-between border-bottom py-2">
                                        <strong>Post Date:</strong>
                                        <span>{{ $job->circular_date ?? 'N/A' }}</span>
                                    </div>

                                    <!-- Deadline -->
                                    <div class="col-md-6 d-flex justify-content-between border-bottom py-2">
                                        <strong>Deadline:</strong>
                                        <span>{{ $job->deadline ?? 'N/A' }}</span>
                                    </div>

                                    <!-- Experience -->
                                    <div class="col-md-6 d-flex justify-content-between border-bottom py-2">
                                        <strong>Experience:</strong>
                                        <span>{{ $job->experience ?? 'N/A' }}</span>
                                    </div>

                                    <!-- Job Image -->
                                    <div class="col-md-6 border-bottom py-2">
                                        <strong>Job Image:</strong><br>
                                        @if ($job->image)
                                            <img src="{{ asset('assets/images/jobs/' . $job->image) }}"
                                                style="width:180px;height:180px;object-fit:cover;border:1px solid #ccc;border-radius:8px;"
                                                class="mt-2">
                                        @else
                                            <p class="text-muted mt-2">No Image</p>
                                        @endif
                                    </div>

                                    <!-- Description -->
                                    <div class="col-12 border-bottom py-2">
                                        <strong>Job Description:</strong>
                                        <div class="mt-2 p-3 border rounded">
                                            {!! $job->description ?? '<span class="text-muted">No Description</span>' !!}
                                        </div>
                                    </div>

                                </div>
                            </div>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });
    </script>
@endsection
