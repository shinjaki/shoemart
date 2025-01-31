<!-- Navigation-->
        <nav class="navbar navbar-expand-lg" style="background: #007BFF;">
            <div class="container px-4 px-lg-5">
                <!-- Logo and Brand -->
                <a class="navbar-brand text-light" href="index.php">ShoeMart</a>
        
                <!-- Toggler button for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <!-- Navigation Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link text-light" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link text-light" href="order_history.php">Order History</a></li>
                    </ul>
                    &nbsp;
                    &nbsp;
                    <!-- Cart and Profile Section -->
                    <div class="d-flex align-items-center">
                        <!-- Cart -->
                        <a href="cart.php" class="btn btn-outline-light me-3" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                        </a>
        
                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <a class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                                href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-person"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item text-dark" href="profile.php">My Account</a></li>
                                <li><a class="dropdown-item text-dark" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>