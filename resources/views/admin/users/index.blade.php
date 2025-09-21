<x-admin-layout>
    @section('title', 'User Management')
    <div class="main-content">
        <div class="dashboard-header">
            <h1>User Management</h1>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-1"></i>
                    User Listings
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class="fas fa-plus"></i> Add User
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
                        <i class="fas fa-upload"></i> Upload CSV
                    </button>
                    <a href="{{ route('admin.reports.print-users') }}" class="btn btn-info btn-sm" target="_blank">
                        <i class="fas fa-print"></i> Print Report
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif



                <!-- Users Table -->
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Degree</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->student_id ?? $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->degree_name }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info view-user" 
                                            data-bs-toggle="modal" data-bs-target="#viewUserModal"
                                            data-user="{{ $user->id }}"
                                            data-first-name="{{ $user->first_name }}"
                                            data-middle-name="{{ $user->middle_name }}"
                                            data-last-name="{{ $user->last_name }}"
                                            data-email="{{ $user->email }}"
                                            data-degree-name="{{ $user->degree_name }}"
                                            data-age="{{ $user->age }}"
                                            data-average-grade="{{ $user->average_grade }}"
                                            data-act-member="{{ $user->act_member }}"
                                            data-leadership="{{ $user->leadership }}"
                                            data-is-board-passer="{{ $user->is_board_passer }}"
                                            data-board-exam-name="{{ $user->board_exam_name }}"
                                            data-board-exam-year="{{ $user->board_exam_year }}"
                                            data-license-number="{{ $user->license_number }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary edit-user" 
                                            data-user="{{ $user->id }}"
                                            data-first-name="{{ $user->first_name }}"
                                            data-middle-name="{{ $user->middle_name }}"
                                            data-last-name="{{ $user->last_name }}"
                                            data-email="{{ $user->email }}"
                                            data-degree-name="{{ $user->degree_name }}"
                                            data-role="{{ $user->role }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-user" 
                                            data-user="{{ $user->id }}"
                                            data-name="{{ $user->first_name }} {{ $user->last_name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- View User Modal -->
                <div class="modal fade" id="viewUserModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Student Information</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Student ID:</strong></div>
                                    <div class="col-md-8" id="view_id"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Full Name:</strong></div>
                                    <div class="col-md-8" id="view_full_name"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Email:</strong></div>
                                    <div class="col-md-8" id="view_email"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Degree:</strong></div>
                                    <div class="col-md-8" id="view_degree_name"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Age:</strong></div>
                                    <div class="col-md-8" id="view_age"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Average Grade:</strong></div>
                                    <div class="col-md-8" id="view_average_grade"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>ACT Member:</strong></div>
                                    <div class="col-md-8" id="view_act_member"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Leadership:</strong></div>
                                    <div class="col-md-8" id="view_leadership"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Board Passer:</strong></div>
                                    <div class="col-md-8" id="view_is_board_passer"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Board Exam Name:</strong></div>
                                    <div class="col-md-8" id="view_board_exam_name"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>Board Exam Year:</strong></div>
                                    <div class="col-md-8" id="view_board_exam_year"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"><strong>License Number:</strong></div>
                                    <div class="col-md-8" id="view_license_number"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                @push('scripts')
                <script>
                $(document).ready(function() {
                    // Handle View Button Click
                    $('.view-user').click(function() {
                        const user = $(this).data();
                        
                        $('#view_id').text(user.user);
                        $('#view_full_name').text(`${user.firstName} ${user.middleName} ${user.lastName}`);
                        $('#view_email').text(user.email);
                        $('#view_degree_name').text(user.degreeName);
                        $('#view_age').text(user.age || 'Not specified');
                        $('#view_average_grade').text(user.averageGrade || 'Not specified');
                        $('#view_act_member').text(user.actMember ? 'Yes' : 'No');
                        $('#view_leadership').text(user.leadership ? 'Yes' : 'No');
                        $('#view_is_board_passer').text(user.isBoardPasser ? 'Yes' : 'No');
                        $('#view_board_exam_name').text(user.boardExamName || 'Not specified');
                        $('#view_board_exam_year').text(user.boardExamYear || 'Not specified');
                        $('#view_license_number').text(user.licenseNumber || 'Not specified');
                    });
                });
                </script>
                @endpush

                <!-- Pagination -->
                @if($users->count() > 0)
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-muted">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                            </div>
                            <div class="text-muted">
                                Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Users pagination">
                                {{ $users->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id" class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="id" name="id" required>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name">
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="degree_name" class="form-label">Degree</label>
                            <input type="text" class="form-control" id="degree_name" name="degree_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_id" class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="edit_id" name="id" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="edit_middle_name" name="middle_name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_degree_name" class="form-label">Degree</label>
                            <input type="text" class="form-control" id="edit_degree_name" name="degree_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_birthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="edit_birthday" name="birthday" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Upload CSV Modal -->
    <div class="modal fade" id="uploadCsvModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Users from CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="uploadCsvForm" action="{{ route('admin.users.upload-csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>CSV Format Requirements:</strong><br>
                            Your CSV file must contain the following columns:<br>
                            <code>ID Number, First Name, Middle Name, Last Name, Degree, Birthday, Email</code><br>
                            <small class="text-muted">The first row should contain the column headers.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">CSV File</label>
                            <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".csv,.xlsx,.xls" required>
                            <div class="form-text">Supported formats: CSV, Excel (.xlsx, .xls). Maximum file size: 10MB</div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Note:</strong> Passwords will be automatically generated using the format: <code>ID Number + Birthday (MM/DD/YY)</code>
                        </div>
                        
                        <!-- Progress bar -->
                        <div class="progress mb-3" style="display: none;" id="uploadProgress">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        
                        <!-- Results display -->
                        <div id="uploadResults" style="display: none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="uploadBtn">
                            <i class="fas fa-upload me-1"></i> Upload Users
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Pagination styling */
        .pagination {
            margin-bottom: 0;
        }
        
        .pagination .page-link {
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 0.25rem;
        }
        
        .pagination .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .pagination .page-item.active .page-link {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
        
        /* Responsive pagination */
        @media (max-width: 768px) {
            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .pagination .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.875rem;
                margin: 1px;
            }
        }
    </style>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();

            // Handle Edit Button Click
            $('.edit-user').click(function() {
                const user = $(this).data();
                const form = $('#editUserForm');
                
                form.attr('action', `{{ route('admin.users.update', '') }}/${user.user}`);
                
                // Fill form fields
                $('#edit_first_name').val(user.firstName);
                $('#edit_middle_name').val(user.middleName);
                $('#edit_last_name').val(user.lastName);
                $('#edit_email').val(user.email);
                $('#edit_degree_name').val(user.degreeName);
                $('#edit_role').val(user.role);
                
                $('#editUserModal').modal('show');
            });

            // Handle Delete Button Click
            $('.delete-user').click(function() {
                const user = $(this).data();
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete ${user.name}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('<form>', {
                            'method': 'POST',
                            'action': `{{ route('admin.users.destroy', '') }}/${user.user}`
                        });
                        
                        form.append(`@csrf`);
                        form.append(`<input type="hidden" name="_method" value="DELETE">`);
                        
                        $(document.body).append(form);
                        form.submit();
                    }
                });
            });

            // Handle form submissions with AJAX
            $('#createUserForm, #editUserForm').on('submit', function(e) {
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
                        let errorMessage = 'Something went wrong!';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                            } else if (xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            } else if (xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                        }
                        
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
            });

            // Handle CSV upload form submission
            $('#uploadCsvForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const formData = new FormData(this);
                const uploadBtn = $('#uploadBtn');
                const progressBar = $('#uploadProgress');
                const resultsDiv = $('#uploadResults');
                
                // Show progress bar and disable button
                progressBar.show();
                uploadBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Uploading...');
                
                // Simulate progress
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.random() * 20;
                    if (progress > 90) progress = 90;
                    progressBar.find('.progress-bar').css('width', progress + '%');
                }, 200);
                
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        clearInterval(progressInterval);
                        progressBar.find('.progress-bar').css('width', '100%');
                        
                        if (response.status === 'success') {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Upload Successful!',
                                text: response.message,
                                timer: 3000
                            });
                            
                            // Show detailed results
                            let resultsHtml = `
                                <div class="alert alert-success">
                                    <h6><i class="fas fa-check-circle me-2"></i>Upload Results:</h6>
                                    <ul class="mb-0">
                                        <li><strong>Users Created:</strong> ${response.data.insertedCount}</li>
                                        <li><strong>Errors:</strong> ${response.data.errorCount}</li>
                                        <li><strong>Total Rows:</strong> ${response.data.totalRows}</li>
                                    </ul>
                                </div>
                            `;
                            
                            if (response.data.errors && response.data.errors.length > 0) {
                                resultsHtml += `
                                    <div class="alert alert-warning">
                                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Errors:</h6>
                                        <ul class="mb-0">
                                            ${response.data.errors.slice(0, 5).map(error => `<li>${error}</li>`).join('')}
                                            ${response.data.errors.length > 5 ? `<li><em>... and ${response.data.errors.length - 5} more errors</em></li>` : ''}
                                        </ul>
                                    </div>
                                `;
                            }
                            
                            if (response.data.generatedCredentials && response.data.generatedCredentials.length > 0) {
                                resultsHtml += `
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-key me-2"></i>Generated Credentials (First 5):</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Username</th>
                                                        <th>Password</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${response.data.generatedCredentials.slice(0, 5).map(cred => `
                                                        <tr>
                                                            <td>${cred.id}</td>
                                                            <td>${cred.name}</td>
                                                            <td><code>${cred.username}</code></td>
                                                            <td><code>${cred.password}</code></td>
                                                        </tr>
                                                    `).join('')}
                                                </tbody>
                                            </table>
                                        </div>
                                        ${response.data.generatedCredentials.length > 5 ? `<small class="text-muted">... and ${response.data.generatedCredentials.length - 5} more users</small>` : ''}
                                    </div>
                                `;
                            }
                            
                            resultsDiv.html(resultsHtml).show();
                            
                            // Reset form and hide modal after delay
                            setTimeout(() => {
                                form[0].reset();
                                resultsDiv.hide();
                                progressBar.hide();
                                $('#uploadCsvModal').modal('hide');
                                location.reload(); // Reload to show new users
                            }, 5000);
                            
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Upload Failed!',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        clearInterval(progressInterval);
                        let errorMessage = 'Upload failed!';
                        
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Error!',
                            text: errorMessage
                        });
                    },
                    complete: function() {
                        // Reset button and progress
                        uploadBtn.prop('disabled', false).html('<i class="fas fa-upload me-1"></i>Upload Users');
                        progressBar.hide();
                    }
                });
            });
        });
    </script>
    @endpush
</x-admin-layout>
