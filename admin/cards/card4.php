<?php
// Include your database connection
include('connection.php');

// Query to get the count of 'Pending' transactions
$pending_sql = "SELECT COUNT(*) AS pending_requests 
                FROM transactions 
                WHERE status = 'Pending'";
$pending_result = mysqli_query($conn, $pending_sql);
$pending_data = mysqli_fetch_assoc($pending_result);
$pending_requests = $pending_data['pending_requests'];

// If no pending requests, set it to 0
if (!$pending_requests) {
    $pending_requests = 0;
}
?>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pending Requests
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo $pending_requests; ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
