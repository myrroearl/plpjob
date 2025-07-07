document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('modelFile');
    const fileDetails = document.querySelector('.file-details');
    const selectedFile = document.querySelector('.selected-file');
    const progressBar = document.querySelector('.progress-bar');

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Handle drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length) {
            fileInput.files = files;
            updateFileDetails(files[0]);
        }
    });

    // Handle file selection
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length) {
            updateFileDetails(e.target.files[0]);
        }
    });

    function updateFileDetails(file) {
        fileDetails.style.display = 'block';
        selectedFile.innerHTML = `
            <i class="fas fa-file-alt text-success"></i>
            <div>
                <div>${file.name}</div>
                <small class="text-muted">${formatFileSize(file.size)}</small>
            </div>
        `;
        
        // Simulate upload progress
        simulateUpload();
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function simulateUpload() {
        let progress = 0;
        progressBar.style.width = '0%';
        
        const interval = setInterval(() => {
            progress += 5;
            progressBar.style.width = progress + '%';
            
            if (progress >= 100) {
                clearInterval(interval);
            }
        }, 100);
    }

    // Add form submission handler
    const uploadForm = document.querySelector('.upload-form');
    uploadForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const progressBar = document.querySelector('.progress-bar');

        try {
            // Disable submit button
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';

            // Send form data with CSRF token
            const response = await fetch(uploadForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                // Show success message using SweetAlert2
                Swal.fire({
                    title: 'Success!',
                    text: result.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the index page using Laravel's route
                        window.location.href = uploadForm.action;
                    }
                });
            } else {
                throw new Error(result.message || 'Unknown error occurred');
            }

        } catch (error) {
            // Show error message
            Swal.fire({
                title: 'Error!',
                text: error.message || 'An error occurred while processing the model',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } finally {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.innerHTML = 'Upload Model';
        }
    });
}); 

