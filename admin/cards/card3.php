<?php
// Include your database connection
include('connection.php');

// Query to get the total number of transactions
$total_sql = "SELECT COUNT(*) AS total_transactions FROM transactions";
$total_result = mysqli_query($conn, $total_sql);
$total_data = mysqli_fetch_assoc($total_result);
$total_transactions = $total_data['total_transactions'];

// Query to get the number of 'Completed' transactions
$completed_sql = "SELECT COUNT(*) AS completed_tasks 
                  FROM transactions 
                  WHERE status = 'Completed'";
$completed_result = mysqli_query($conn, $completed_sql);
$completed_data = mysqli_fetch_assoc($completed_result);
$completed_tasks = $completed_data['completed_tasks'];

// Calculate the percentage of completed tasks
if ($total_transactions > 0) {
    $percentage = ($completed_tasks / $total_transactions) * 100;
} else {
    $percentage = 0;
}
?>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Tasks
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                <?php echo number_format($percentage, 2) . "%"; ?>
                            </div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: <?php echo $percentage; ?>%" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
