document.addEventListener('DOMContentLoaded', function() {
    // Employment Trends Chart
    const trendsChart = new Chart(document.getElementById('employmentTrendsChart'), {
        type: 'line',
        data: {
            labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
            datasets: [{
                label: 'Employment Rate',
                data: [75, 78, 80, 82, 83, 85.6],
                borderColor: '#2E7D32',
                backgroundColor: 'rgba(46, 125, 50, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 70,
                    max: 100
                }
            }
        }
    });

    // Course Employment Chart
    const courseChart = new Chart(document.getElementById('courseEmploymentChart'), {
        type: 'doughnut',
        data: {
            labels: ['BSIT', 'BSCS', 'BSIS'],
            datasets: [{
                data: [92, 88, 85],
                backgroundColor: [
                    '#2E7D32',
                    '#0d6efd',
                    '#0dcaf0'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Industry Distribution Chart
    const industryChart = new Chart(document.getElementById('industryChart'), {
        type: 'bar',
        data: {
            labels: ['IT Services', 'Software Dev', 'BPO', 'Banking', 'Others'],
            datasets: [{
                label: 'Distribution',
                data: [45, 25, 15, 10, 5],
                backgroundColor: '#2E7D32'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Salary Distribution Chart
    const salaryChart = new Chart(document.getElementById('salaryChart'), {
        type: 'bar',
        data: {
            labels: ['<20k', '20-25k', '25-30k', '30-35k', '35-40k', '>40k'],
            datasets: [{
                label: 'Employees',
                data: [10, 25, 35, 20, 7, 3],
                backgroundColor: '#2E7D32'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}); 