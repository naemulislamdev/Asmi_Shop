@extends('layouts.admin')

@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Sitemap Download') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>

                        <li>
                            <span>{{ __('Sitemap Download') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-12">
                    <div class="card boder-o py-5">

                        <div class="card-body pt-0 text-center border-0">
                            <a href="{{ route('admin-sitemap-download') }}" class="btn btn-primary btn-lg"><i
                                    style="font-size: 25px" class="fa fa-download"></i>
                                Download Sitemap</a>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
    </div>
@endsection
