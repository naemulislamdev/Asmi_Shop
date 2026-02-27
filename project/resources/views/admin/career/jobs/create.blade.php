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
                            <span disabled>{{ __('Create Job') }}</span>
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
                            <form action="{{ route('career.job-store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="jobTitle">Job Title</label>
                                        <input required autofocus type="text" name="title" id="jobTitle"
                                            class="form-control " placeholder="Enter Job Title">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="department">Department</label>
                                        <select name="department_id" id="department" class="form-select">
                                            <option value="" selected disabled>Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="description">Job Description</label>
                                        <div class="text-editor">
                                            <textarea class="nic-edit" name="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="jobLocation">Job Location</label>
                                        <input type="text" name="job_location" id="jobLocation" class="form-control "
                                            placeholder="Enter Job Location">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="jobType">Job Type</label>
                                        <select class="form-select" name="type" id="type">
                                            <option value="">Select Job Type</option>
                                            <option value="Full Time">Full Time</option>
                                            <option value="Part Time">Part Time</option>
                                            <option value="Internship">Internship</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="experience">Post Date</label>
                                        <input type="date" name="circular_date" id="circular_date" class="form-control">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="experience">Deadline</label>
                                        <input type="date" name="deadline" id="deadline" class="form-control">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <span class="mb-2">Upload Job-post Image</span>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="customFileEg1"
                                                class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="customFileEg1">choose
                                                file</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img style="width: 200px;height:200px;border: 1px solid; border-radius: 10px;"
                                            id="viewer" src="" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="experience">Experience</label>
                                        <input type="text" name="experience" id="experience" class="form-control"
                                            placeholder="Enter Experience">
                                    </div>


                                </div>
                                <div class="mt-5 text-center">
                                    <button type="submit" class="btn btn-primary w-50 ">
                                        {{ __('Create Job') }}
                                    </button>
                                </div>
                            </form>
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
