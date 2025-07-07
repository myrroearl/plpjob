<x-admin-layout>
    @section('title', 'Manage Jobs')
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Manage Jobs</h1>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-briefcase me-1"></i>
                    Job Listings
                </div>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createJobModal">
                    <i class="fas fa-plus"></i> Add Job
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <table id="jobsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Location</th>
                            <th>Job Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->company->name }}</td>
                                <td>{{ $job->location }}</td>
                                <td>{{ $job->job_type }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary edit-job" 
                                            data-job="{{ $job->id }}"
                                            data-title="{{ $job->title }}"
                                            data-company="{{ $job->company_id }}"
                                            data-location="{{ $job->location }}"
                                            data-job_type="{{ $job->job_type }}"
                                            data-salary_min="{{ $job->salary_min }}"
                                            data-salary_max="{{ $job->salary_max }}"
                                            data-currency="{{ $job->currency }}"
                                            data-job_description="{{ $job->job_description }}"
                                            data-responsibilities="{{ $job->responsibilities }}"
                                            data-qualifications="{{ $job->qualifications }}"
                                            data-benefits="{{ $job->benefits }}"
                                            data-industry="{{ $job->industry }}"
                                            data-application_link="{{ $job->application_link }}"
                                            data-expires_at="{{ $job->expires_at->format('Y-m-d') }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger delete-job" 
                                            data-job="{{ $job->id }}"
                                            data-title="{{ $job->title }}">
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

    <!-- Create Job Modal -->
    <div class="modal fade" id="createJobModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createJobForm" action="{{ route('admin.jobs.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="company_id" class="form-label">Company</label>
                            <select class="form-control" id="company_id" name="company_id" required>
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="job_type" class="form-label">Job Type</label>
                            <select class="form-control" id="job_type" name="job_type" required>
                                <option value="">Select Job Type</option>
                                <option value="full-time">Full Time</option>
                                <option value="part-time">Part Time</option>
                                <option value="contract">Contract</option>
                                <option value="internship">Internship</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="responsibilities" class="form-label">Responsibilities</label>
                            <textarea class="form-control" id="responsibilities" name="responsibilities" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="qualifications" class="form-label">Qualifications</label>
                            <textarea class="form-control" id="qualifications" name="qualifications" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="benefits" class="form-label">Benefits</label>
                            <textarea class="form-control" id="benefits" name="benefits" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="industry" class="form-label">Industry</label>
                            <input type="text" class="form-control" id="industry" name="industry" required>
                        </div>
                        <div class="mb-3">
                            <label for="salary_min" class="form-label">Minimum Salary</label>
                            <input type="number" class="form-control" id="salary_min" name="salary_min" required>
                        </div>
                        <div class="mb-3">
                            <label for="salary_max" class="form-label">Maximum Salary</label>
                            <input type="number" class="form-control" id="salary_max" name="salary_max" required>
                        </div>
                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <input type="text" class="form-control" id="currency" name="currency" required>
                        </div>
                        <div class="mb-3">
                            <label for="job_description" class="form-label">Job Description</label>
                            <textarea class="form-control" id="job_description" name="job_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="application_link" class="form-label">Application Link</label>
                            <input type="url" class="form-control" id="application_link" name="application_link" placeholder="https://..." required>
                        </div>
                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" id="expires_at" name="expires_at" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Job Modal -->
    <div class="modal fade" id="editJobModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editJobForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Job Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_company_id" class="form-label">Company</label>
                            <select class="form-control" id="edit_company_id" name="company_id" required>
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="edit_location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_job_type" class="form-label">Job Type</label>
                            <select class="form-control" id="edit_job_type" name="job_type" required>
                                <option value="">Select Job Type</option>
                                <option value="full-time">Full Time</option>
                                <option value="part-time">Part Time</option>
                                <option value="contract">Contract</option>
                                <option value="internship">Internship</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_responsibilities" class="form-label">Responsibilities</label>
                            <textarea class="form-control" id="edit_responsibilities" name="responsibilities" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_qualifications" class="form-label">Qualifications</label>
                            <textarea class="form-control" id="edit_qualifications" name="qualifications" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_benefits" class="form-label">Benefits</label>
                            <textarea class="form-control" id="edit_benefits" name="benefits" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_industry" class="form-label">Industry</label>
                            <input type="text" class="form-control" id="edit_industry" name="industry" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_salary_min" class="form-label">Minimum Salary</label>
                            <input type="number" class="form-control" id="edit_salary_min" name="salary_min" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_salary_max" class="form-label">Maximum Salary</label>
                            <input type="number" class="form-control" id="edit_salary_max" name="salary_max" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_currency" class="form-label">Currency</label>
                            <input type="text" class="form-control" id="edit_currency" name="currency" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_job_description" class="form-label">Job Description</label>
                            <textarea class="form-control" id="edit_job_description" name="job_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_application_link" class="form-label">Application Link</label>
                            <input type="url" class="form-control" id="edit_application_link" name="application_link" placeholder="https://..." required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_expires_at" class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" id="edit_expires_at" name="expires_at" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#jobsTable').DataTable();

            // Handle Edit Button Click
            $('.edit-job').click(function() {
                const job = $(this).data();
                const form = $('#editJobForm');
                
                form.attr('action', `{{ route('admin.jobs.update', '') }}/${job.job}`);
                
                // Fill form fields
                $('#edit_title').val(job.title);
                $('#edit_company_id').val(job.company);
                $('#edit_location').val(job.location);
                $('#edit_job_type').val(job.job_type);
                $('#edit_salary_min').val(job.salary_min);
                $('#edit_salary_max').val(job.salary_max);
                $('#edit_currency').val(job.currency);
                $('#edit_job_description').val(job.job_description);
                $('#edit_responsibilities').val(job.responsibilities);
                $('#edit_qualifications').val(job.qualifications);
                $('#edit_benefits').val(job.benefits);
                $('#edit_industry').val(job.industry);
                $('#edit_application_link').val(job.application_link);
                
                // Format the date to YYYY-MM-DD for the date input
                if (job.expires_at) {
                    const date = new Date(job.expires_at);
                    const formattedDate = date.toISOString().split('T')[0];
                    $('#edit_expires_at').val(formattedDate);
                }
                
                $('#editJobModal').modal('show');
            });

            // Handle Delete Button Click
            $('.delete-job').click(function() {
                const job = $(this).data();
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete ${job.title}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('<form>', {
                            'method': 'POST',
                            'action': `{{ route('admin.jobs.destroy', '') }}/${job.job}`
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
            $('#createJobForm, #editJobForm').on('submit', function(e) {
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
                        console.error('Error:', xhr.responseJSON); // Add this for debugging
                        
                        let errorMessage = 'Something went wrong!';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                // Handle validation errors
                                errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                            } else if (xhr.responseJSON.error) {
                                // Handle specific error message
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

        document.addEventListener('DOMContentLoaded', function() {
            const createForm = document.getElementById('createJobForm');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    const submitBtn = createForm.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = 'Submitting...'; // Optional: show feedback
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editJobForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    const submitBtn = editForm.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = 'Updating...'; // Optional: show feedback
                    }
                });
            }
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