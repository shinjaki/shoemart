  <style>
    .sidebar{
        background:  #0056b3;
    }

    .collapse-item:hover {
        background-color: #007BFF !important;
        color: white !important;
    }
  </style>
  
  <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3" style="color: white;">ShoeMart <sup>ADMIN</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Product Management
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manage Products</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded text-light" style="background: #0056b3;">
                        <a class="collapse-item text-light" href="products.php">View Products</a>
                        <a class="collapse-item text-light" href="category.php">View Categories</a>
                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Transaction History
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransactions"
                    aria-expanded="true" aria-controls="collapseTransactions">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Manage Transactions</span>
                </a>
                <div id="collapseTransactions" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="background: #008170;">
                    <div class="py-2 collapse-inner rounded" style="background: #0056b3;">
                        <a class="collapse-item text-light" href="pending_orders.php">Pending Orders</a>
                        <a class="collapse-item text-light" href="completed_orders.php">Completed Orders</a>
                        <a class="collapse-item text-light" href="cancelled_orders.php">Cancelled Orders</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <div class="sidebar-heading">
                Account Management
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Manage Accounts</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="py-2 collapse-inner rounded" style="background: #0056b3;">
                        <a class="collapse-item text-light" href="customer_account.php">Customer Accounts</a>
                        <a class="collapse-item text-light" href="admin_account.php">Admin Accounts</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->