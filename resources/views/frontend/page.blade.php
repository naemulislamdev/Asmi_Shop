@extends('layouts.front')

@section('content')
<section class="gs-breadcrumb-section bg-class p-0"
        data-background="{{ $gs->breadcrumb_banner ? asset('assets/images/' . $gs->breadcrumb_banner) : asset('assets/images/noimage.png') }}">
        <div class="container">
            <div class="row justify-content-center content-wrapper mt-3">
                <div class="col-12">

                    <nav class="custom-breadcrumb mb-2 mb-lg-0">
                        <a href="{{ url('/') }}">Home</a>
                        <span class="separator"><i class="fa fa-chevron-right"></i></span>
                        <span class="active">{{ $page->title }}</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <h1 class="text-dark text-center h2">{{ $page->title }}</h1>
  </section>

<!-- blog wrapper start -->
<div class="gs-blog-wrapper wow-replaced mt-4 pt-0" data-wow-delay=".1s">
    <div class="container">
      <div class="row">
        <div class="col-12 gs-main-blog-wrapper">
          <div class="gs-blog-details-wrapper">
            <div class="gs-blog-card">
              

              <h4 class="fea-title mb-24">
                {{ $page->title }}
              </h4>
              <p class="mb-10">
                {!! clean($page->details , array('Attr.EnableID' => true)) !!}
              </p>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- blog wrapper end -->


@endsection
