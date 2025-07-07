document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTables
    if (document.getElementById('resultsTable')) {
        $('#resultsTable').DataTable({
            responsive: true,
            order: [[12, 'desc']] // Sort by employability probability
        });
    }
    
    // File upload handling
    const uploadArea = document.getElementById('uploadArea');
    const csvFileInput = document.getElementById('csvFile');
    
    if (uploadArea && csvFileInput) {
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function() {
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            if (e.dataTransfer.files.length) {
                csvFileInput.files = e.dataTransfer.files;
                updateFileName(e.dataTransfer.files[0].name);
            }
        });
        
        csvFileInput.addEventListener('change', function() {
            if (this.files.length) {
                updateFileName(this.files[0].name);
            }
        });
    }
    
    // Form submission with AJAX
    const forecastForm = document.getElementById('studentForecastForm');
    if (forecastForm) {
        forecastForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading indicator
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            submitBtn.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Show success message
                    showAlert('success', 'Predictions generated successfully.');
                    
                    // Refresh the page to show new results
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showAlert('error', data.message || 'An error occurred.');
                }
            })
            .catch(error => {
                showAlert('error', 'An error occurred while processing the request.');
                console.error('Error:', error);
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalBtnText;
                submitBtn.disabled = false;
            });
        });
    }
    
    // Filter functionality
    const yearFilter = document.getElementById('yearFilter');
    const degreeFilter = document.getElementById('degreeFilter');
    
    if (yearFilter && degreeFilter && $.fn.dataTable) {
        const table = $('#resultsTable').DataTable();
        
        yearFilter.addEventListener('change', function() {
            const yearValue = this.value;
            table.column(10).search(yearValue).draw(); // 10 is the Year Graduated column index
        });
        
        degreeFilter.addEventListener('change', function() {
            const degreeValue = this.value;
            table.column(3).search(degreeValue).draw(); // 3 is the Degree column index
        });
    }
});

function updateFileName(fileName) {
    const uploadContent = document.querySelector('.upload-content-small');
    if (uploadContent) {
        uploadContent.innerHTML = `
            <i class="fas fa-file-csv fa-2x mb-2"></i>
            <p class="mb-1">${fileName}</p>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="resetFileInput()">
                <i class="fas fa-times"></i> Remove
            </button>
        `;
    }
}

function resetFileInput() {
    const csvFileInput = document.getElementById('csvFile');
    csvFileInput.value = '';
    
    const uploadContent = document.querySelector('.upload-content-small');
    uploadContent.innerHTML = `
        <i class="fas fa-file-csv fa-2x mb-2"></i>
        <p class="mb-1">Drop your CSV file here</p>
        <button type="button" class="btn btn-outline-success btn-sm" onclick="document.getElementById('csvFile').click()">
            Browse
        </button>
    `;
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Add the loading state styles
const styles = `
<style>
.loading-state {
    padding: 20px;
    text-align: center;
}

.loading-spinner {
    border: 4px solid #f3f3f3;
    border-radius: 50%;
    border-top: 4px solid #28a745;
    width: 40px;
    height: 40px;
    margin: 0 auto 20px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-steps {
    max-width: 300px;
    margin: 0 auto;
    text-align: left;
}

.step {
    padding: 10px;
    margin: 5px 0;
    color: #6c757d;
    transition: all 0.3s ease;
    opacity: 0.5;
}

.step i {
    margin-right: 10px;
    width: 20px;
}

.step.active {
    color: #28a745;
    opacity: 1;
    font-weight: bold;
    transform: scale(1.05);
}

.step.completed {
    color: #28a745;
    opacity: 0.8;
}

.step.completed i {
    color: #28a745;
}
</style>
`;

// Append styles to head
document.head.insertAdjacentHTML('beforeend', styles);

// Initialize DataTable with filtering
$(document).ready(function() {
    // Get existing DataTable instance if it exists
    let table = $('#resultsTable').DataTable();
    
    // Custom filtering function
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        const selectedYear = $('#yearFilter').val();
        const selectedDegree = $('#degreeFilter').val();
        
        const rowYear = data[10]; // Year Graduated column index
        const rowDegree = data[3]; // Degree column index

        // If no filters are selected, show all rows
        if (!selectedYear && !selectedDegree) return true;

        // Check year filter
        const yearMatch = !selectedYear || rowYear === selectedYear;
        
        // Check degree filter
        const degreeMatch = !selectedDegree || rowDegree === selectedDegree;

        return yearMatch && degreeMatch;
    });

    // Event listeners for filter changes
    $('#yearFilter, #degreeFilter').on('change', function() {
        table.draw();
    });
}); 