@extends('layouts.admin')

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('Career') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Job Applications') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Job Applications') }} </a>
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
                        <div class="row mb-3 justify-content-end align-items-center">
                            <div class="col-md-3">
                                <label>From:</label>
                                <input type="date" id="from_date" class="form-control">
                            </div>
                            <div>
                                <i class="fa fa-arrow-right mt-3" aria-hidden="true"></i>
                            </div>

                            <div class="col-md-3">
                                <label>To:</label>
                                <input type="date" id="to_date" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <button id="filter" class="btn btn-primary mt-3">Filter</button>
                            </div>

                            <div class="col-md-2">
                                <button id="reset" class="btn btn-secondary mt-3">Reset</button>
                            </div>
                        </div>

                        <div class="table-responsive">

                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('SL#') }}</th>
                                        <th>{{ __(' Date') }}</th>
                                        <th>{{ __('Name') }}</th>

                                        <th>{{ __('Phone') }}</th>
                                        <th>{{ __('Position') }}</th>
                                        <th>{{ __('CV') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Change Status') }}</th>
                                        <th>{{ __('Options') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header d-block text-center">
                    <h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">{{ __('You are about to delete this Application.') }}</p>
                    <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="" class="d-inline delete-form" method="POST">
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- DELETE MODAL ENDS --}}

    {{-- View Modal --}}
    <div class="modal fade" id="viewApplicationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Application Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Full Name</th>
                            <td id="modalFullName"></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td id="modalEmail"></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td id="modalPhone"></td>
                        </tr>
                        <tr>
                            <th>Position</th>
                            <td id="modalPosition"></td>
                        </tr>
                        <tr>
                            <th>CV</th>
                            <td id="modalCV"></td>
                        </tr>
                        <tr>
                            <th>Experience</th>
                            <td id="modalExperience"> </td>
                        </tr>
                        <tr>
                            <th>Portfolio</th>
                            <td id="modalPortfolio"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="modalStatus"></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.viewApplicationBtn', function() {
            var button = $(this);

            $('#modalFullName').text(button.data('full_name'));
            $('#modalEmail').text(button.data('email'));
            $('#modalPhone').text(button.data('phone'));
            $('#modalPosition').text(button.data('position'));

            // CV as button link
            var cvUrl = button.data('cv');
            $('#modalCV').html('<a class="btn btn-info btn-sm" href="' + cvUrl +
                '" target="_blank"> <i class="fa fa-eye"></i> View CV</a>');

            // Experience + ' years'
            var exp = button.data('experience');
            $('#modalExperience').text(exp + ' years');

            // Portfolio link color
            var portfolioUrl = button.data('portfolio');
            $('#modalPortfolio').html('<a href="' + portfolioUrl + '" target="_blank" style="color: #007bff;">' +
                portfolioUrl + '</a>');

            // Status badge
            var status = button.data('status').toLowerCase();
            var badgeClass = 'badge-secondary';
            if (status == 'shortlisted') badgeClass = 'badge-success';
            else if (status == 'pending') badgeClass = 'badge-warning';
            else if (status == 'rejected') badgeClass = 'badge-danger';

            $('#modalStatus').html('<span class="badge ' + badgeClass + '">' + button.data('status') + '</span>');
        });
    </script>

    {{-- DATA TABLE --}}
    <script type="text/javascript">
        (function($) {
            "use strict";


            var table = $('#geniustable').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('career.application-datatables') }}',
                    data: function(d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,

                    },
                    {
                        data: 'applyed_date',
                        name: 'applyed_date',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'cv',
                        name: 'cv'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'change_status',
                        name: 'change_status'
                    },
                    {
                        data: 'action',
                        searchable: false,
                        orderable: false
                    }

                ],
                language: {
                    processing: '<img src="{{ asset('assets/images/' . $gs->admin_loader) }}">'
                },
                drawCallback: function(settings) {
                    $('.select').niceSelect();
                }
            });

            $('#filter').on('click', function() {
                table.draw();
            });

            $('#reset').on('click', function() {
                $('#from_date').val('');
                $('#to_date').val('');
                table.draw();
            });

            $(document).on('change', '.changeStatus', function() {

                let id = $(this).attr("id");
                let status = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                });


                $.ajax({
                    url: "{{ route('career.application-status') }}",
                    type: "POST",
                    data: {
                        id: id,
                        status: status
                    },
                    success: function() {
                        table.ajax.reload(null, false);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

        })(jQuery);
    </script>

    {{-- DATA TABLE ENDS --}}
@endsection
