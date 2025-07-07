document.addEventListener('DOMContentLoaded', function() {
    // Handle settings form submission
    document.getElementById('generalSettingsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveSettings();
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle confidence threshold range input
    const confidenceThreshold = document.querySelector('input[name="confidence_threshold"]');
    confidenceThreshold.addEventListener('input', function(e) {
        e.target.nextElementSibling.querySelector('.text-success').textContent = e.target.value + '%';
    });
});

function saveSettings() {
    const loadingOverlay = createLoadingOverlay();
    document.querySelector('.main-content').appendChild(loadingOverlay);

    // Simulate saving settings
    setTimeout(() => {
        loadingOverlay.remove();
        showSuccessMessage('Settings saved successfully!');
    }, 1500);
}

function updateModel() {
    if (confirm('Are you sure you want to update the AI model? This may take several minutes.')) {
        const loadingOverlay = createLoadingOverlay('Updating AI Model...');
        document.querySelector('.main-content').appendChild(loadingOverlay);

        // Simulate model update
        setTimeout(() => {
            loadingOverlay.remove();
            showSuccessMessage('AI Model updated successfully!');
        }, 3000);
    }
}

function clearCache() {
    if (confirm('Are you sure you want to clear the system cache?')) {
        const loadingOverlay = createLoadingOverlay('Clearing Cache...');
        document.querySelector('.main-content').appendChild(loadingOverlay);

        // Simulate cache clearing
        setTimeout(() => {
            loadingOverlay.remove();
            showSuccessMessage('Cache cleared successfully!');
        }, 1500);
    }
}

function backupData() {
    const loadingOverlay = createLoadingOverlay('Creating Backup...');
    document.querySelector('.main-content').appendChild(loadingOverlay);

    // Simulate backup process
    setTimeout(() => {
        loadingOverlay.remove();
        showSuccessMessage('Backup created successfully!');
        // Trigger download
        const link = document.createElement('a');
        link.href = '#';
        link.download = 'backup_' + new Date().toISOString().slice(0,10) + '.zip';
        link.click();
    }, 2000);
}

function exportSettings() {
    const settings = {
        system_name: document.querySelector('input[name="system_name"]').value,
        institution_name: document.querySelector('input[name="institution_name"]').value,
        academic_year: document.querySelector('input[name="academic_year"]').value,
        // Add other settings
    };

    const blob = new Blob([JSON.stringify(settings, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'settings.json';
    link.click();
}

function createLoadingOverlay(message = 'Saving...') {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = `
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="mt-2">${message}</div>
    `;
    return overlay;
}

function showSuccessMessage(message) {
    // Implement toast or alert message
    alert(message);
} 