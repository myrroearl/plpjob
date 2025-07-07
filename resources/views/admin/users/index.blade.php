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
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="fas fa-plus"></i> Add User
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif



                <!-- Users Table -->
                <table id="usersTable" class="table table-bordered table-striped">
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
                                <td>{{ $user->id }}</td>
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
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
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
        });
    </script>
    @endpush
</x-admin-layout>