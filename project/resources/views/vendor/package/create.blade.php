@extends('layouts.vendor')
@section('content')
    <div class="gs-vendor-outlet">
        <!-- breadcrumb start  -->
        <div class="gs-vendor-breadcrumb has-mb">
                    <div class="d-flex align-items-center gap-4">
                        <a href="{{route("vendor-package-index")}}" class="back-btn">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </a>

                        <h4>@lang('Create Package')</h4>
                    </div>

            <ul class="breadcrumb-menu">
                <li>
                    <a href="{{ route('vendor.dashboard') }}" class="text-capitalize">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="#4C3533" class="home-icon-vendor-panel-breadcrumb">
                            <path
                                d="M9 21V13.6C9 13.0399 9 12.7599 9.109 12.546C9.20487 12.3578 9.35785 12.2049 9.54601 12.109C9.75993 12 10.04 12 10.6 12H13.4C13.9601 12 14.2401 12 14.454 12.109C14.6422 12.2049 14.7951 12.3578 14.891 12.546C15 12.7599 15 13.0399 15 13.6V21M2 9.5L11.04 2.72C11.3843 2.46181 11.5564 2.33271 11.7454 2.28294C11.9123 2.23902 12.0877 2.23902 12.2546 2.28295C12.4436 2.33271 12.6157 2.46181 12.96 2.72L22 9.5M4 8V17.8C4 18.9201 4 19.4802 4.21799 19.908C4.40974 20.2843 4.7157 20.5903 5.09202 20.782C5.51985 21 6.0799 21 7.2 21H16.8C17.9201 21 18.4802 21 18.908 20.782C19.2843 20.5903 19.5903 20.2843 19.782 19.908C20 19.4802 20 18.9201 20 17.8V8L13.92 3.44C13.2315 2.92361 12.8872 2.66542 12.5091 2.56589C12.1754 2.47804 11.8246 2.47804 11.4909 2.56589C11.1128 2.66542 10.7685 2.92361 10.08 3.44L4 8Z"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="{{route("vendor.dashboard")}}" class="text-capitalize">
                        @lang('Dashboard')
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="text-capitalize"> @lang('Create Package') </a>
                </li>
            </ul>
        </div>
        <!-- breadcrumb end -->

        <!-- Edit Profile area start  -->
        <div class="vendor-edit-profile-section-wrapper">
            <div class="gs-edit-profile-section">

                <form class="edit-profile-area" action="{{ route('vendor-package-create') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="form-group">
                            <label for="title">@lang('Title')</label>
                            <input type="text" id="title" class="form-control" placeholder="@lang('Title')" value=""
                                name="title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="subtitle">@lang('Duration')</label>
                            <input type="text" id="subtitle" class="form-control" placeholder="@lang('Duration')" value=""
                                name="subtitle">
                            @error('subtitle')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">@lang('Price')</label>
                            <input type="number"  step="any" id="price" class="form-control" placeholder="@lang('Price')" value=""
                                name="price">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-12">
                            <button class="template-btn btn-forms" type="submit">
                                @lang('Save')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Profile area end  -->
    </div>
@endsection
