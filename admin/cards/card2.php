<?php
// Include your database connection
include('connection.php');

// Get the current year
$current_year = date('Y');

// Query to sum total_amount for the current year where the status is 'Completed'
$sql = "SELECT SUM(total_amount) AS total_earnings 
        FROM transactions 
        WHERE YEAR(transaction_date) = '$current_year' 
        AND status = 'Completed'";  // Added the status condition
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
$total_earnings = $data['total_earnings'];

// If no earnings, set to 0
if (!$total_earnings) {
    $total_earnings = 0;
}
?>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Earnings (Annual)
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo "$" . number_format($total_earnings, 2); ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
