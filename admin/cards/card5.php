<?php
// Include your database connection
include('connection.php');

// Get the monthly earnings for the current year, including all transactions
$current_year = date('Y');

// Query to get total_amount for each month, based on transaction_date
$sql = "SELECT MONTH(transaction_date) AS month, SUM(total_amount) AS monthly_earnings
        FROM transactions
        WHERE YEAR(transaction_date) = '$current_year'
        GROUP BY MONTH(transaction_date)
        ORDER BY MONTH(transaction_date)";
$result = mysqli_query($conn, $sql);

// Initialize arrays to hold the month names and earnings
$months = [];
$earnings = [];

// Fetch the data and populate the arrays
while ($data = mysqli_fetch_assoc($result)) {
    $months[] = date("F", mktime(0, 0, 0, $data['month'], 10)); // Month name
    $earnings[] = $data['monthly_earnings'];
}

// If no earnings data, fill with zeros
if (empty($earnings)) {
    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $earnings = array_fill(0, 12, 0);
}
?>

<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Get the month names and earnings from PHP
const months = <?php echo json_encode($months); ?>;
const earnings = <?php echo json_encode($earnings); ?>;

// Get the canvas element
var ctx = document.getElementById('myAreaChart').getContext('2d');

// Create the chart
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: months,  // Labels for each month
        datasets: [{
            label: 'Monthly Earnings (₱)', // Label with Peso sign
            data: earnings,  // Data for monthly earnings
            backgroundColor: 'rgba(28, 200, 138, 0.1)',  // Light green fill
            borderColor: 'rgba(28, 200, 138, 1)',  // Darker green border
            borderWidth: 2,
            fill: true,  // Fill the area under the line
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    display: false
                }
            },
            y: {
                ticks: {
                    beginAtZero: true,
                    callback: function(value) {
                        return '₱' + value.toLocaleString();  // Format Y axis with Peso symbol
                    }
                },
                grid: {
                    borderColor: "#cccccc",
                    borderWidth: 1
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return '₱' + tooltipItem.raw.toLocaleString();  // Format tooltip value with Peso symbol
                    }
                }
            }
        }
    }
});
</script>
