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
                            <h3 class="card-title mb-4">Add Data to Existing Model</h3>
                            
                            @if($recentUploads->count() > 0)
                                <div class="alert alert-info mb-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Latest Model:</strong> {{ $recentUploads->first()['model_name'] }} 
                                    ({{ number_format($recentUploads->first()['total_alumni']) }} alumni)
                                </div>
                                
                                <form action="{{ route('admin.model-upload.add-data') }}" method="POST" enctype="multipart/form-data" class="add-data-form">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label">Data File to Add</label>
                                        <div class="upload-area" id="addDataArea">
                                            <div class="upload-content text-center">
                                                <i class="fas fa-file-plus fa-3x mb-3"></i>
                                                <input type="file" class="file-input" id="dataFile" name="dataFile" required style="opacity: 0; position: absolute;">
                                                <h5>Drag & Drop your data file here</h5>
                                                <p class="text-muted">or</p>
                                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('dataFile').click()">
                                                    Browse Files
                                                </button>
                                                <p class="mt-2 text-muted small">Supported formats: .csv, .xlsx</p>
                                                <p class="mt-2 text-warning small">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Make sure the file has the same column structure as the existing model
                                                </p>
                                            </div>
                                            <div class="file-details mt-3" style="display: none;">
                                                <div class="selected-file"></div>
                                                <div class="progress mt-2" style="height: 10px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="button" class="btn btn-light me-2">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Add Data to Model</button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>No existing model found!</strong> Please upload a model first before adding data.
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

            // Handle file upload for add data form
            const addDataFileInput = document.getElementById('dataFile');
            const addDataArea = document.getElementById('addDataArea');
            const addDataForm = document.querySelector('.add-data-form');

            if (addDataFileInput && addDataArea) {
                // File selection handler
                addDataFileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const fileDetails = addDataArea.querySelector('.file-details');
                        const selectedFile = addDataArea.querySelector('.selected-file');
                        const uploadContent = addDataArea.querySelector('.upload-content');
                        
                        // Show file details
                        selectedFile.innerHTML = `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-csv text-primary me-2"></i>
                                <div>
                                    <strong>${file.name}</strong>
                                    <br>
                                    <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                                </div>
                            </div>
                        `;
                        
                        uploadContent.style.display = 'none';
                        fileDetails.style.display = 'block';
                    }
                });

                // Drag and drop functionality
                addDataArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    addDataArea.classList.add('drag-over');
                });

                addDataArea.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    addDataArea.classList.remove('drag-over');
                });

                addDataArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    addDataArea.classList.remove('drag-over');
                    
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        addDataFileInput.files = files;
                        addDataFileInput.dispatchEvent(new Event('change'));
                    }
                });
            }

            // Handle add data form submission
            if (addDataForm) {
                addDataForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    console.log('Add data form submitted');
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    
                    // Debug form data
                    console.log('Form data entries:');
                    for (let [key, value] of formData.entries()) {
                        console.log(key, value);
                    }
                    
                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding Data...';
                    
                    // Show progress bar
                    const progressBar = addDataArea.querySelector('.progress-bar');
                    if (progressBar) {
                        progressBar.style.width = '0%';
                        progressBar.parentElement.style.display = 'block';
                        
                        // Simulate progress
                        let progress = 0;
                        const progressInterval = setInterval(() => {
                            progress += Math.random() * 30;
                            if (progress > 90) progress = 90;
                            progressBar.style.width = progress + '%';
                        }, 200);
                        
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
                            progressBar.style.width = '100%';
                            
                            if (data.status === 'success') {
                                // Show success message with countdown
                                showAlert('success', data.message + ' Page will refresh in 3 seconds to show updated data...');
                                
                                // Reset form
                                addDataForm.reset();
                                const fileDetails = addDataArea.querySelector('.file-details');
                                const uploadContent = addDataArea.querySelector('.upload-content');
                                fileDetails.style.display = 'none';
                                uploadContent.style.display = 'block';
                                
                                // Update the alert with countdown
                                let countdown = 3;
                                const countdownInterval = setInterval(() => {
                                    const alertElement = document.querySelector('.alert:last-child');
                                    if (alertElement) {
                                        alertElement.innerHTML = `
                                            <i class="fas fa-check-circle me-2"></i>
                                            ${data.message} Page will refresh in ${countdown} seconds to show updated data...
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
                                showAlert('error', data.message || 'An error occurred while adding data');
                            }
                        })
                        .catch(error => {
                            clearInterval(progressInterval);
                            console.error('Fetch error:', error);
                            showAlert('error', 'An error occurred while adding data: ' + error.message);
                        })
                        .finally(() => {
                            // Reset button
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalText;
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
