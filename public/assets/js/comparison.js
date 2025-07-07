document.addEventListener('DOMContentLoaded', function() {
    // Initialize the comparison chart
    const ctx = document.getElementById('comparisonChart').getContext('2d');
    const comparisonChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Actual Rate',
                data: [82, 83, 85, 84, 86, 85, 87, 86, 88, 87, 89, 85.6],
                borderColor: '#2E7D32',
                backgroundColor: 'rgba(46, 125, 50, 0.1)',
                fill: true
            }, {
                label: 'Predicted Rate',
                data: [81, 82, 84, 83, 85, 84, 86, 85, 87, 86, 88, 83.2],
                borderColor: '#1976D2',
                backgroundColor: 'rgba(25, 118, 210, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 75,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Employment Rate (%)'
                    }
                }
            }
        }
    });

    // Function to update timeframe
    window.updateTimeframe = function(timeframe) {
        // Update active button
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');

        // Update chart data based on timeframe
        // This would typically fetch new data from the server
        // For now, we'll just simulate different data
        let labels, actualData, predictedData;

        switch(timeframe) {
            case 'yearly':
                labels = ['2019', '2020', '2021', '2022', '2023', '2024'];
                actualData = [75, 78, 80, 82, 84, 85.6];
                predictedData = [74, 77, 79, 81, 83, 83.2];
                break;
            case 'quarterly':
                labels = ['Q1 2023', 'Q2 2023', 'Q3 2023', 'Q4 2023', 'Q1 2024'];
                actualData = [82, 83, 84, 85, 85.6];
                predictedData = [81, 82, 83, 84, 83.2];
                break;
            case 'monthly':
                // Keep current monthly data
                return;
        }

        comparisonChart.data.labels = labels;
        comparisonChart.data.datasets[0].data = actualData;
        comparisonChart.data.datasets[1].data = predictedData;
        comparisonChart.update();
    };
}); 