<style>
    .close {
        z-index: 99;
        background: white !important;
        padding: 3px 8px !important;
        margin: -23px -12px -1rem auto !important;
        border-radius: 50%;
    }
</style>
@php
    $banner = \App\Models\Slider::inRandomOrder()
        ->where(['published' => 1, 'type' => 'promo_offer'])
        ->first();
@endphp

@if (isset($banner))
    <div class="modal fade" id="popup-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding: 1px;border-bottom: 0px!important;">
                    <button type="button" id="close-pModal" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 3px!important; cursor: pointer"
                    onclick="location.href='{{ $banner['url'] }}'">
                    <img class="d-block w-100" src="{{ asset('assets/images/slider/') }}/{{ $banner['photo'] }}"
                        alt="popup modal image">
                </div>
            </div>
        </div>
    </div>
@endif
