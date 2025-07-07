<x-admin-layout>
    @section('title', 'Manage Companies')
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-building me-1"></i>
                    Manage Companies' Partnerships
                </div>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createCompanyModal">
                    <i class="fas fa-plus"></i> Add Company
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <table id="companiesTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Industry</th>
                            <th>Website</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->industry }}</td>
                                <td>
                                    @if($company->website)
                                        <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary edit-company" 
                                            data-company="{{ $company->id }}"
                                            data-name="{{ $company->name }}"
                                            data-industry="{{ $company->industry }}"
                                            data-website="{{ $company->website }}"
                                            data-description="{{ $company->description }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-company" 
                                            data-company="{{ $company->id }}"
                                            data-name="{{ $company->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Company Modal -->
    <div class="modal fade" id="createCompanyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createCompanyForm" action="{{ route('admin.companies.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry</label>
                            <input type="text" class="form-control" id="industry" name="industry">
                        </div>
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="website" name="website">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Company</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Company Modal -->
    <div class="modal fade" id="editCompanyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editCompanyForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_industry" class="form-label">Industry</label>
                            <input type="text" class="form-control" id="edit_industry" name="industry">
                        </div>
                        <div class="mb-3">
                            <label for="edit_website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="edit_website" name="website">
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Company</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#companiesTable').DataTable();

            // Handle Edit Button Click
            $('.edit-company').click(function() {
                const company = $(this).data();
                const form = $('#editCompanyForm');
                
                // Update the form action URL with the correct route
                form.attr('action', `{{ route('admin.companies.update', '') }}/${company.company}`);
                
                // Fill form fields
                $('#edit_name').val(company.name);
                $('#edit_industry').val(company.industry);
                $('#edit_website').val(company.website);
                $('#edit_description').val(company.description);
                
                // Show modal
                $('#editCompanyModal').modal('show');
            });

            // Handle Delete Button Click
            $('.delete-company').click(function() {
                const company = $(this).data();
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete ${company.name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('<form>', {
                            'method': 'POST',
                            'action': `{{ route('admin.companies.destroy', '') }}/${company.company}`
                        });
                        
                        // Properly append CSRF and method fields
                        form.append(`@csrf`);
                        form.append(`<input type="hidden" name="_method" value="DELETE">`);
                        
                        $(document.body).append(form);
                        form.submit();
                    }
                });
            });

            // Handle form submissions with AJAX
            $('#createCompanyForm, #editCompanyForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        // Hide modal
                        $('.modal').modal('hide');
                        
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 1500
                        }).then(() => {
                            // Reload page to show updated data
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .modal-dialog {
            max-width: 500px;
        }
        
        .modal-content {
            border-radius: 8px;
        }
        
        .modal-header {
            background-color: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }
        
        .btn-close:focus {
            box-shadow: none;
        }
        
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
    </style>
    @endpush
</x-admin-layout> 