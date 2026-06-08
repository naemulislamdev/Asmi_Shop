@extends('layouts.load')
@section('content')
    <div class="content-area">

        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area" id="modalEdit">
                            @include('alerts.admin.form-error')
                            <form id="geniusformdata" action="{{ route('admin-userinfo-status-update', $data->id) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Status') }} *</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <select name="status" required="">
                                            <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>
                                                {{ __('Pending') }}</option>
                                            <option value="hold" {{ $data->status == 'hold' ? 'selected' : '' }}>
                                                {{ __('Hold') }}</option>
                                            <option value="processing" {{ $data->status == 'processing' ? 'selected' : '' }}>
                                                {{ __('Processing') }}</option>
                                            <option value="on delivery"
                                                {{ $data->status == 'on delivery' ? 'selected' : '' }}>
                                                {{ __('On Delivery') }}</option>
                                            <option value="completed" {{ $data->status == 'completed' ? 'selected' : '' }}>
                                                {{ __('Completed') }}</option>
                                            <option value="cancelled" {{ $data->status == 'cancelled' ? 'selected' : '' }}>
                                                {{ __('Cancel') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Note') }} *</h4>
                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <textarea class="input-field" name="custome_note" placeholder="{{ __('Enter Custome Note Here') }}"></textarea>
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">

                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
