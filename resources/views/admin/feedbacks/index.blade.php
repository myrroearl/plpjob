<x-admin-layout>
    @section('title', 'Manage Feedbacks')
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Manage Feedbacks</h1>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-comments me-1"></i>
                    Feedback Listings
                </div>
                <div class="btn-group">
                    <select class="form-select form-select-sm" id="sortSelect">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>By Status</option>
                    </select>
                    <a href="{{ route('admin.reports.print-feedbacks') }}" class="btn btn-success btn-sm" target="_blank">
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

                <div class="table-responsive">
                    <table id="feedbacksTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Employment Status</th>
                                <th>Company</th>
                                <th>Position</th>
                                <th>Duration</th>
                                <th>Feedback</th>
                                <th>Comments</th>
                                <th>Date Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->user->first_name }} {{ $feedback->user->last_name }}</td>
                                    <td>
                                        @switch($feedback->employment_status)
                                            @case('yes')
                                                <span class="badge bg-success">Employed</span>
                                                @break
                                            @case('no')
                                                <span class="badge bg-danger">Unemployed</span>
                                                @break
                                            @default
                                                <span class="badge bg-warning">Other</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $feedback->company_name ?? 'N/A' }}</td>
                                    <td>{{ $feedback->position ?? 'N/A' }}</td>
                                    <td>{{ $feedback->employment_duration ?? 'N/A' }}</td>
                                    <td>{{ $feedback->improvements ?? 'N/A' }}</td>
                                    <td>{{ $feedback->additional_comments ?? 'N/A' }}</td>
                                    <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger delete-feedback" 
                                                data-feedback-id="{{ $feedback->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $feedbacks->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#feedbacksTable').DataTable({
                "order": [[5, "desc"]],
                "pageLength": 10
            });

            // Handle sorting
            $('#sortSelect').change(function() {
                const sort = $(this).val();
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('sort', sort);
                window.location.href = currentUrl.toString();
            });

            // Handle Delete Button Click
            $('.delete-feedback').click(function() {
                const feedbackId = $(this).data('feedback-id');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to delete this feedback?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('admin.feedbacks.destroy', '') }}/${feedbackId}`,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON.error || 'Something went wrong!'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</x-admin-layout>
