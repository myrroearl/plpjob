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
                                        <h6>{{ $upload->model_name }}</h6>
                                        <div class="upload-meta">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt"></i> 
                                                {{ $upload->last_updated->format('M d, Y') }}
                                            </small>
                                            <small class="text-success">
                                                <i class="fas fa-chart-line"></i> 
                                                {{ number_format($upload->prediction_accuracy, 1) }}% accuracy
                                            </small>
                                            <small class="text-primary">
                                                <i class="fas fa-users"></i> 
                                                {{ number_format($upload->total_alumni) }} alumni
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
</x-admin-layout>
