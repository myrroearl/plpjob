document.addEventListener('DOMContentLoaded', function() {
    // Initialize the forecast chart
    const ctx = document.getElementById('forecastChart').getContext('2d');
    const forecastChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: generateMonthLabels(24),
            datasets: [{
                label: 'Historical Data',
                data: generateRandomData(12),
                borderColor: '#2E7D32',
                backgroundColor: 'rgba(46, 125, 50, 0.1)',
                fill: false
            }, {
                label: 'Forecast',
                data: generateRandomData(12).concat(generateRandomData(12)),
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                borderDash: [5, 5],
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Employment Rate (%)'
                    }
                }
            }
        }
    });

    // Handle form submission
    document.getElementById('forecastForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your ARIMA calculation logic here
        updateChart();
    });

    function generateMonthLabels(count) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const labels = [];
        const currentDate = new Date();
        
        for(let i = 0; i < count; i++) {
            const monthIndex = (currentDate.getMonth() + i) % 12;
            const year = currentDate.getFullYear() + Math.floor((currentDate.getMonth() + i) / 12);
            labels.push(`${months[monthIndex]} ${year}`);
        }
        
        return labels;
    }

    function generateRandomData(count) {
        return Array.from({length: count}, () => Math.random() * 20 + 70);
    }

    function updateChart() {
        // Simulate loading
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'loading-overlay';
        loadingOverlay.innerHTML = '<div class="spinner-border text-success" role="status"></div>';
        document.getElementById('forecastChart').parentElement.appendChild(loadingOverlay);

        // Simulate API call delay
        setTimeout(() => {
            // Update chart with new data
            forecastChart.data.datasets[1].data = generateRandomData(24);
            forecastChart.update();
            loadingOverlay.remove();
        }, 1500);
    }
}); 