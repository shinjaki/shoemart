<?php
include('connection.php');

// Fetch the monthly income for transactions with status "Completed"
$query = "SELECT SUM(total_amount) AS total_income
          FROM transactions
          WHERE status = 'Completed' 
          AND MONTH(transaction_date) = MONTH(CURRENT_DATE()) 
          AND YEAR(transaction_date) = YEAR(CURRENT_DATE())";

$result = mysqli_query($conn, $query);

$total_income = 0;
if ($row = mysqli_fetch_assoc($result)) {
    $total_income = $row['total_income'] ?? 0; // Default to 0 if no completed transactions
}
?>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Earnings (Monthly)
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        ₱<?php echo number_format($total_income, 2); ?>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
