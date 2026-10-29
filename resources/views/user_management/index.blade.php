@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    {{-- toast starts --}}
    @include('components.message')
    {{-- toast Ends --}}

    <div class="page-wrapper">
        <div class="page-content">

            @include('layouts.sessionmsg')

            <div class="container">
                <div class="d-flex justify-content-between">
                    <h2>User List</h2>
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>
                </div>
                <div class="table-responsive">
                    <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded dynamically via AJAX -->
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.7/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.7/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                processing: true,
                serverSide: false, // Change to true if large dataset
                ajax: {
                    url: '{{ route('user.get') }}', // Ensure this route exists
                    dataSrc: 'data'
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Serial number
                        }
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'roles'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            return data == 1 ? '<span class="badge bg-success">Active</span>' :
                                '<span class="badge bg-danger">Inactive</span>';
                        }
                    },

                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <a href="/user-edit/${row.id}">
                            <i class="fa-solid fa-pen text-secondary"></i>
                        </a>
                        <a href="javascript:void(0);" class="delete-user" data-id="${row.id}" title="Delete">
                         <i class="fa-solid fa-trash-can text-danger"></i>
                        </a>
                    `;
                        }
                    }
                ]
            });

            // Handle delete button click
            $(document).on('click', '.delete-user', function() {
                let id = $(this).data('id');
                deletePermission(id);
            });
        });

        function deletePermission(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/user-delete/${id}`,
                        type: 'POST', // Keep POST if Laravel requires _method
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#userTable').DataTable().ajax.reload();
                            Swal.fire("Deleted!", "User has been deleted.",
                                "success");
                            // Show the success message dynamically
                            showAlert(response.success, 'success');
                        },

                        error: function(error) {
                            let errorMessage = error.responseJSON?.error ||
                                "Something went wrong.";
                            showAlert(errorMessage, 'error');
                        }
                    });
                }
            });
        }


        // Function to show alerts dynamically
        function showAlert(message, type) {
            let alertId = type === 'success' ? 'successAlert' : 'errorAlert';
            let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';

            console.log("Alert ID:", alertId);

            // Remove existing alert before adding a new one
            $('#' + alertId).remove();

            let alertHtml = `
             <div id="${alertId}" class="alert ${alertClass} alert-dismissible fade show" role="alert"
              style="position: fixed; right: 30px; top: 30px; z-index: 9999; width: 50%;">
              ${message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
             `;

            // Append the alert dynamically
            $('body').append(alertHtml);

            // Auto-remove after 3 seconds
            setTimeout(function() {
                console.log("Fading out alert:", alertId);
                $('#' + alertId).fadeOut('slow', function() {
                    console.log("Removing alert:", alertId);
                    $(this).remove();
                });
            }, 3000);
        }
    </script>
@endpush
