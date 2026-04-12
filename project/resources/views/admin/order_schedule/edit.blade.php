@extends('layouts.load')

@section('content')
    <div class="content-area">

        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            @include('alerts.admin.form-error')
                            <form id="geniusformdata" action="{{ route('schedule.update', $data->id) }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="heading"> Schedule Title *</label>
                                            <input type="text" class="input-field" name="title"
                                                placeholder="{{ __('Enter Title') }}" required value="{{ $data->title}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="heading">Form Time *</label>
                                            <input type="time" class="input-field" name="time_form" required value="{{ $data->time_form}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="heading">To Time *</label>
                                            <input type="time" class="input-field" name="time_to" required value="{{ $data->time_to}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="heading"> Offers (optional)</label>
                                            <input type="text" class="input-field" name="offer"
                                                placeholder="{{ __('Enter offer') }}" value="{{ $data->offer}}">
                                        </div>
                                    </div>
                                </div>
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
