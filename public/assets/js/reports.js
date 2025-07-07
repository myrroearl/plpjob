document.addEventListener('DOMContentLoaded', function() {
    // Handle select all checkbox
    document.getElementById('selectAll').addEventListener('change', function(e) {
        const checkboxes = document.querySelectorAll('.report-select');
        checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
    });

    // Handle report form submission
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        generateReport();
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function generateReport() {
    const loadingOverlay = createLoadingOverlay();
    document.querySelector('.main-content').appendChild(loadingOverlay);

    // Simulate report generation
    setTimeout(() => {
        loadingOverlay.remove();
        showSuccessMessage('Report generated successfully!');
        // Add the new report to the table
        addReportToTable({
            name: `Report_${new Date().getTime()}`,
            type: document.getElementById('reportType').value,
            date: new Date().toLocaleDateString(),
            format: document.getElementById('reportFormat').value
        });
    }, 2000);
}

function createLoadingOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = `
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-2">Generating Report...</div>
    `;
    return overlay;
}

function showSuccessMessage(message) {
    // Implement toast or alert message
    alert(message);
}

function addReportToTable(report) {
    const tbody = document.querySelector('table tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="checkbox" class="form-check-input report-select"></td>
        <td>${report.name}</td>
        <td><span class="badge bg-success">${report.type}</span></td>
        <td>${report.date}</td>
        <td><i class="fas fa-file-${report.format} text-danger"></i> ${report.format.toUpperCase()}</td>
        <td>
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-success" onclick="viewReport('${report.name}')">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="downloadReport('${report.name}')">
                    <i class="fas fa-download"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteReport('${report.name}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    `;
    tbody.insertBefore(tr, tbody.firstChild);
}

function loadTemplate(type) {
    // Implement template loading logic
    console.log(`Loading ${type} template...`);
}

function viewReport(reportId) {
    const modal = new bootstrap.Modal(document.getElementById('reportPreviewModal'));
    // Load report content
    document.getElementById('reportPreviewContent').innerHTML = `
        <div class="text-center">
            <h4>Report Preview</h4>
            <p>Loading preview for report ID: ${reportId}</p>
        </div>
    `;
    modal.show();
}

function downloadReport(reportId) {
    console.log(`Downloading report: ${reportId}`);
}

function deleteReport(reportId) {
    if (confirm('Are you sure you want to delete this report?')) {
        console.log(`Deleting report: ${reportId}`);
    }
}

function bulkDownload() {
    const selectedReports = document.querySelectorAll('.report-select:checked');
    console.log(`Downloading ${selectedReports.length} reports...`);
}

function refreshReports() {
    console.log('Refreshing reports list...');
} 