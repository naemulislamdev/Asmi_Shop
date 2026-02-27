@extends('layouts.admin')

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('Career') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Jobs Department') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Jobs Department') }} </a>
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

                        <div class="table-responsive">
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('SL#') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Status') }}</th>
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
                    <p class="text-center">{{ __('You are about to delete this Job Department.') }}</p>
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

    {{-- ADD DEPARTMENT MODAL --}}
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <form id="departmentForm" action="{{ route('career.department-store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Department Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter department name"
                                required autofocus>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- ADD DEPARTMENT MODAL --}}

    {{-- EDIT DEPARTMENT MODAL --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <form id="editForm">
                    @csrf
                    <input type="hidden" id="edit_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Department</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Department Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- EDIT DEPARTMENT MODAL --}}
@endsection

@section('scripts')
    {{-- DATA TABLE --}}

    <script type="text/javascript">
        (function($) {
            "use strict";

            var table = $('#geniustable').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: '{{ route('career.department-datatables') }}?type=all',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        searchable: false,
                        orderable: false
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

            $(function() {
                $(".btn-area").append(
                    '<div class="col-sm-4 table-contents">' +
                    '<button class="add-btn btn btn-primary" data-toggle="modal" data-target="#addDepartmentModal">' +
                    '<i class="fas fa-plus"></i> ' +
                    '<span class="remove-mobile">Add Department</span>' +
                    '</button>' +
                    '</div>'
                );
            });

            // Store Department via AJAX

            $(document).on('submit', '#departmentForm', function(e) {
                e.preventDefault();

                let form = $(this);
                let url = form.attr('action');
                let formData = form.serialize();



                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(response) {
                        $('#addDepartmentModal').modal('hide');
                        form[0].reset();
                        // Optional: DataTable reload
                        table.ajax.reload(null, false);

                    },
                    error: function(err) {
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            });

            // Edit Department - Show data in modal
            $('#editModal').on('show.bs.modal', function(e) {
                let button = $(e.relatedTarget);

                $('#edit_id').val(button.data('id'));
                $('#edit_name').val(button.data('name'));
            });

            // Update Department via AJAX
            $('#editForm').on('submit', function(e) {
                e.preventDefault();

                let id = $('#edit_id').val();

                $.ajax({
                    url: "{{ route('career.department-update') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: $('#edit_name').val(),
                        id: id
                    },
                    success: function() {
                        $('#editModal').modal('hide');
                        table.ajax.reload(null, false);

                    }
                });
            });



        })(jQuery);
    </script>

    {{-- DATA TABLE ENDS --}}
@endsection
