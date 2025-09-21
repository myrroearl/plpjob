<x-admin-layout>
    @section('title', 'Upload Model')
    <div class="main-content">
        <div class="dashboard-header">
            <h1>Upload Data Model</h1>
            <p class="text-muted">Upload and manage your ARIMA prediction models</p>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="dashboard-card">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-4" id="modelTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="true">
                                <i class="fas fa-upload me-2"></i>Upload New Model
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="add-data-tab" data-bs-toggle="tab" data-bs-target="#add-data" type="button" role="tab" aria-controls="add-data" aria-selected="false">
                                <i class="fas fa-plus me-2"></i>Add Data to Existing Model
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="view-dataset-tab" data-bs-toggle="tab" data-bs-target="#view-dataset" type="button" role="tab" aria-controls="view-dataset" aria-selected="false">
                                <i class="fas fa-database me-2"></i>View Dataset
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="modelTabsContent">
                        <!-- Upload New Model Tab -->
                        <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                            <h3 class="card-title mb-4">Upload New Model</h3>
                            
                            <form action="{{ route('admin.model-upload.store') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                                @csrf
                                <div class="mb-4">
                                    <label for="modelName" class="form-label">Model Name</label>
                                    <input type="text" class="form-control" id="modelName" name="modelName" required>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="uploadToDataset" name="uploadToDataset" value="1">
                                        <label class="form-check-label" for="uploadToDataset">
                                            <strong>Also upload to MySQL Dataset Table</strong>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        This will truncate the existing dataset table and upload the CSV data to MySQL. 
                                        Make sure your CSV file contains all required columns matching the dataset table structure.
                                    </small>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label">Model File</label>
                                    <div class="upload-area" id="uploadArea">
                                        <div class="upload-content text-center">
                                            <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                                            <input type="file" class="file-input" id="modelFile" name="modelFile" required style="opacity: 0; position: absolute;">
                                            <h5>Drag & Drop your file here</h5>
                                            <p class="text-muted">or</p>
                                            <button type="button" class="btn btn-outline-success" onclick="document.getElementById('modelFile').click()">
                                                Browse Files
                                            </button>
                                            <p class="mt-2 text-muted small">Supported formats: .csv, .xlsx</p>
                                        </div>
                                        <div class="file-details mt-3" style="display: none;">
                                            <div class="selected-file"></div>
                                            <div class="progress mt-2" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <button type="button" class="btn btn-light me-2">Cancel</button>
                                    <button type="submit" class="btn btn-success">Upload Model</button>
                                </div>
                            </form>
                        </div>

                        <!-- Add Data to Existing Model Tab -->
                        <div class="tab-pane fade" id="add-data" role="tabpanel" aria-labelledby="add-data-tab">
                            <h3 class="card-title mb-4">Retrain Model</h3>
                            
                            @if($recentUploads->count() > 0)
                                @php
                                    $readyToSyncCount = \App\Models\User::where('skills_completed', true)->where('role', 'user')->count();
                                @endphp
                                
                                <div class="alert alert-info mb-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Latest Model:</strong> {{ $recentUploads->first()['model_name'] }} 
                                    ({{ number_format($recentUploads->first()['total_alumni']) }} alumni)
                                </div>
                                
                                <div class="alert alert-success mb-4">
                                    <i class="fas fa-users me-2"></i>
                                    <strong>Ready to Sync:</strong> {{ number_format($readyToSyncCount) }} students have completed their skills profiles and are ready for model training.
                                </div>
                                
                                <div class="sync-data-section">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <i class="fas fa-sync-alt text-primary me-2"></i>
                                                        Automatic Data Sync
                                                    </h5>
                                                    <p class="card-text text-muted mb-4">
                                                        This will automatically fetch data from students who have completed their skills profiles 
                                                        and sync it to the dataset table for model training.
                                                    </p>
                                                    
                                                    <div class="sync-info mb-4">
                                                        <h6 class="text-dark mb-3">What will be synced:</h6>
                                                        <ul class="list-unstyled">
                                                            <li class="mb-2">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <strong>{{ number_format($readyToSyncCount) }} students</strong> with <code>skills_completed = true</code>
                                                            </li>
                                                            <li class="mb-2">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                Academic information (grades, CGPA, year graduated)
                                                            </li>
                                                            <li class="mb-2">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                Skills ratings (all degree-specific skills)
                                                            </li>
                                                            <li class="mb-2">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                Leadership and organization participation
                                                            </li>
                                                            <li class="mb-2">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                Board examination status
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        <strong>Note:</strong> This process will update existing records or create new ones based on student numbers. 
                                                        After sync, the <code>skills_completed</code> flag will be reset to <code>false</code> for all synced users.
                                                        No manual file upload is required.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="card border-primary">
                                                <div class="card-body text-center">
                                                    <i class="fas fa-database fa-3x text-primary mb-3"></i>
                                                    <h5 class="card-title">Ready to Sync</h5>
                                                    <div class="mb-3">
                                                        <span class="badge bg-success fs-6">{{ number_format($readyToSyncCount) }} Students</span>
                                                    </div>
                                                    <p class="card-text text-muted mb-4">
                                                        Click the button below to start the automatic sync process.
                                                    </p>
                                                    
                                                    <form action="{{ route('admin.model-upload.add-data') }}" method="POST" class="add-data-form">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                                            <i class="fas fa-sync-alt me-2"></i>
                                                            Retrain Model
                                                        </button>
                                                    </form>
                                                    
                                                    <div class="progress mt-3" style="display: none;" id="syncProgress">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>No existing model found!</strong> Please upload a model first before syncing data.
                                </div>
                            @endif
                        </div>

                        <!-- View Dataset Tab -->
                        <div class="tab-pane fade" id="view-dataset" role="tabpanel" aria-labelledby="view-dataset-tab">
                            <h3 class="card-title mb-4">Dataset Records</h3>
                            
                            <div class="alert alert-info mb-4">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Dataset Information:</strong> This table shows all records currently stored in the dataset table used for model training.
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Number</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th>Degree</th>
                                            <th>Year Graduated</th>
                                            <th>CGPA</th>
                                            <th>Soft Skills</th>
                                            <th>Hard Skills</th>
                                            <th>Employability</th>
                                            <th>Board Passer</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $dataset = \App\Models\Student::orderBy('created_at', 'desc')->limit(20)->get();
                                        @endphp
                                        @forelse($dataset as $record)
                                            <tr>
                                                <td>{{ $record->student_number }}</td>
                                                <td>{{ $record->gender }}</td>
                                                <td>{{ $record->age }}</td>
                                                <td>{{ $record->degree }}</td>
                                                <td>{{ $record->year_graduated }}</td>
                                                <td>{{ $record->cgpa }}</td>
                                                <td>{{ $record->soft_skills_ave }}</td>
                                                <td>{{ $record->hard_skills_ave }}</td>
                                                <td>{{ $record->employability }}</td>
                                                <td>
                                                    <span class="badge {{ $record->board_passer ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $record->board_passer ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                                <td>{{ $record->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center text-muted">
                                                    <i class="fas fa-database fa-2x mb-2"></i>
                                                    <br>No dataset records found. Please sync data from users first.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($dataset->count() > 0)
                                <div class="mt-3">
                                    <a href="{{ route('admin.model-upload.view-dataset') }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-2"></i>View All Dataset Records
                                    </a>
                                    <small class="text-muted ms-3">
                                        Showing first 20 records. Click "View All" to see complete dataset with pagination.
                                    </small>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-card">
                    <h3 class="card-title mb-4">Upload Guidelines</h3>
                    <div class="guidelines">
                        <div class="guideline-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>File must be in CSV or Excel format</span>
                        </div>
                        <div class="guideline-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Maximum file size: 10MB</span>
                        </div>
                        <div class="guideline-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Data must include required columns</span>
                        </div>
                        <div class="guideline-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>Ensure data is properly formatted</span>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-card">
                    <h3 class="card-title mb-3">Recent Uploads</h3>
                    <div class="recent-uploads">
                        @if($recentUploads->count() > 0)
                            @foreach($recentUploads as $upload)
                                <div class="upload-item">
                                    <i class="fas fa-file-alt text-success"></i>
                                    <div class="upload-info">
                                        <h6>{{ $upload['model_name'] }}</h6>
                                        <div class="upload-meta">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt"></i> 
                                                {{ \Carbon\Carbon::parse($upload['last_updated'])->format('M d, Y') }}
                                            </small>
                                            <small class="text-success">
                                                <i class="fas fa-chart-line"></i> 
                                                {{ number_format($upload['prediction_accuracy'], 1) }}% accuracy
                                            </small>
                                            <small class="text-primary">
                                                <i class="fas fa-users"></i> 
                                                {{ number_format($upload['total_alumni']) }} alumni
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p>No models uploaded yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/upload.js') }}"></script>
    <script>
        // Handle tab switching and form functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tabs
            var triggerTabList = [].slice.call(document.querySelectorAll('#modelTabs button'))
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl)
                
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault()
                    tabTrigger.show()
                })
            })

            // Handle sync data form
            const addDataForm = document.querySelector('.add-data-form');

            // Upload form submission is handled by upload.js

            // Handle sync data form submission
            if (addDataForm) {
                addDataForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    console.log('Sync data form submitted');
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    const progressBar = document.getElementById('syncProgress');
                    
                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Syncing Data...';
                    
                    // Show progress bar
                    if (progressBar) {
                        progressBar.style.display = 'block';
                        progressBar.querySelector('.progress-bar').style.width = '0%';
                        
                        // Simulate progress
                        let progress = 0;
                        const progressInterval = setInterval(() => {
                            progress += Math.random() * 20;
                            if (progress > 90) progress = 90;
                            progressBar.querySelector('.progress-bar').style.width = progress + '%';
                        }, 300);
                        
                        // Submit form
                        console.log('Sending fetch request to:', this.action);
                        fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => {
                            console.log('Response received:', response.status, response.statusText);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            clearInterval(progressInterval);
                            progressBar.querySelector('.progress-bar').style.width = '100%';
                            
                            if (data.status === 'success') {
                                // Show success message with detailed information
                                let message = data.message;
                                if (data.data) {
                                    message += `<br><br><strong>Sync Details:</strong><br>
                                               • New records: ${data.data.newRecordsCount}<br>
                                               • Updated records: ${data.data.updatedRecordsCount}<br>
                                               • Total alumni count: ${data.data.newTotal}`;
                                }
                                
                                showAlert('success', message + '<br><br>Page will refresh in 3 seconds to show updated data...');
                                
                                // Update the alert with countdown
                                let countdown = 3;
                                const countdownInterval = setInterval(() => {
                                    const alertElement = document.querySelector('.alert:last-child');
                                    if (alertElement) {
                                        alertElement.innerHTML = `
                                            <i class="fas fa-check-circle me-2"></i>
                                            ${message}<br><br>Page will refresh in ${countdown} seconds to show updated data...
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        `;
                                    }
                                    countdown--;
                                    
                                    if (countdown < 0) {
                                        clearInterval(countdownInterval);
                                        window.location.reload();
                                    }
                                }, 1000);
                                
                                // Also reload after 4 seconds as backup
                                setTimeout(() => {
                                    window.location.reload();
                                }, 4000);
                            } else {
                                showAlert('error', data.message || 'An error occurred while syncing data');
                            }
                        })
                        .catch(error => {
                            clearInterval(progressInterval);
                            console.error('Fetch error:', error);
                            showAlert('error', 'An error occurred while syncing data: ' + error.message);
                        })
                        .finally(() => {
                            // Reset button
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
                            
                            // Hide progress bar after a delay
                            setTimeout(() => {
                                if (progressBar) {
                                    progressBar.style.display = 'none';
                                }
                            }, 2000);
                        });
                    }
                });
            }


            // Function to show alerts
            function showAlert(type, message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
                alertDiv.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                // Insert at the top of the main content
                const mainContent = document.querySelector('.main-content');
                mainContent.insertBefore(alertDiv, mainContent.firstChild);
                
                // Auto-remove after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
        });
    </script>
</x-admin-layout>
