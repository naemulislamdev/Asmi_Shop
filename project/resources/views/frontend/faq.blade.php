@extends('layouts.front')
@section('css')
<style>
    .custom-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        font-size: 14px;
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
    }

    /* links */
    .custom-breadcrumb a {
        color: #6c757d;
        text-decoration: none;
        transition: 0.3s;
    }

    .custom-breadcrumb a:hover {
        color: #007bff;
    }

    /* separator icon */
    .custom-breadcrumb .separator {
        margin: 0 8px;
        color: #adb5bd;
        font-size: 12px;
    }

    /* active item */
    .custom-breadcrumb .active {
        color: #212529;
        font-weight: 600;
    }

    /* optional: spacing fix for mobile */
    @media (max-width: 576px) {
        .custom-breadcrumb {
            font-size: 13px;
            padding: 8px 10px;
        }
    }
</style>
@endsection
@section('content')

      <section class="gs-breadcrumb-section bg-class p-0"
        data-background="{{ $gs->breadcrumb_banner ? asset('assets/images/' . $gs->breadcrumb_banner) : asset('assets/images/noimage.png') }}">
        <div class="container">
            <div class="row justify-content-center content-wrapper mt-3">
                <div class="col-12">

                    <nav class="custom-breadcrumb mb-2 mb-lg-0 bg-transparent">
                        <a href="{{ url('/') }}">Home</a>
                        <span class="separator"><i class="fa fa-chevron-right"></i></span>
                        <span class="active">FAQ</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <h1 class="text-dark text-center h2">@lang('FAQ')</h1>

    <div class="gs-faq-section p-0">
      <div class="container">
        <div class="faq-box">
          <div class="accordion hyp-accordians accordion-flush" id="faqlist">
            @foreach($faqs as $key => $faq)
            <div class="accordion-item wow-replaced" data-wow-delay=".1s">
              <h2 class="accordion-header">
                <button class="accordion-button {{$loop->first ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-{{$key}}"
                  aria-expanded="true">
                  {{ $faq->title }}
                </button>
              </h2>
              <div id="faq-content-{{$key}}" class="accordion-collapse collapse {{$loop->first ? 'show' : ''}}" data-bs-parent="#faqlist">
                <div class="accordion-body">
                  {!! clean($faq->details , array('Attr.EnableID' => true)) !!}
                </div>
              </div>
            </div>
            @endforeach
  
      
           
          </div>
        </div>
      </div>
    </div>


@endsection
