<?php 
include('connection.php');

// Fetch categories
$categoryQuery = "SELECT * FROM category";
$categoryResult = $conn->query($categoryQuery);

if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 2) {
    header("Location: login.php");
    exit;
}

// Search functionality
$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = $conn->real_escape_string($_GET['search']);
    $searchQuery = "AND product_name LIKE '%$searchTerm%'";
}
?>

<section id="popular" style="padding: 40px 20px; text-align: center;">
    <!-- Search Bar -->
    <form id="searchForm" method="GET" action="" style="margin-bottom: 30px; display: flex; justify-content: center;">
        <input type="text" name="search" id="searchInput" placeholder="Search for a product.." style="padding: 10px; width: 500px; border-radius: 5px; border: 1px solid #ddd; margin-right: 10px; border: 1px solid black;">
        <button type="submit" style="padding: 10px 20px; background-color: #007BFF; color: #fff; border: none; border-radius: 5px;">Search</button>
    </form>

    <div id="productContainer">
        <?php if ($categoryResult && $categoryResult->num_rows > 0): ?>
            <?php while ($category = $categoryResult->fetch_assoc()): ?>
                <div class="category-section" style="margin-bottom: 40px;">
                    <h3 class="mt-5 mb-3 fw-bold" style="font-size: 1.5rem; margin-bottom: 20px;"><?php echo htmlspecialchars($category['category_name']); ?></h3>

                    <?php
                    // Pagination logic
                    $categoryId = $category['category_id'];
                    $limit = 8;
                    $page = isset($_GET["page_$categoryId"]) ? (int)$_GET["page_$categoryId"] : 1;
                    $offset = ($page - 1) * $limit;

                    // Query to fetch paginated products for the category with search filter
                    $productQuery = "SELECT * FROM products WHERE category_id = $categoryId AND stock > 0 $searchQuery LIMIT $limit OFFSET $offset";
                    $productResult = $conn->query($productQuery);

                    // Query to count total products in this category with search filter
                    $countQuery = "SELECT COUNT(*) as total FROM products WHERE category_id = $categoryId AND stock > 0 $searchQuery";
                    $countResult = $conn->query($countQuery);
                    $totalProducts = $countResult->fetch_assoc()['total'];
                    $totalPages = ceil($totalProducts / $limit);
                    ?>

                    <div class="popular-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px;">
                        <?php if ($productResult->num_rows > 0): ?>
                            <?php while ($product = $productResult->fetch_assoc()): ?>
                                <div class="product-box" style="width: 250px; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; text-align: left; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
                                    <a href="product_details.php?id=<?php echo $product['product_id']; ?>" class="product-box-img" style="display: block; overflow: hidden; background: transparent;">
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                                    </a>
                                        <div class="product-box-text" style="padding: 15px; height: 100%;">
                                        <a href="product_details.php?id=<?php echo $product['product_id']; ?>" class="product-text-title" style="font-size: 1.2rem; color: black; text-decoration: none;"><?php echo htmlspecialchars($product['product_name']); ?></a>
                                        <a href="product_details.php?id=<?php echo $product['product_id']; ?>" style="margin: 10px 0; font-size: 0.9rem; color:rgb(78, 78, 78); text-decoration: none;"><?php echo htmlspecialchars($product['description']); ?></a>
                                        <a href="product_details.php?id=<?php echo $product['product_id']; ?>" style="margin: 10px 0; font-size: 1rem; color: black; font-weight: bold; text-decoration: none;">₱<?php echo number_format($product['price'], 2); ?></a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p style="font-size: 1.2rem; color: #999;">No products available in this category.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination links -->
                    <nav>
                        <ul class="pagination justify-content-center mt-4">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?page_<?php echo $categoryId; ?>=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>

                <div class="divider" style="border: 1px solid black;"></div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="font-size: 1.2rem; color: #999;">No categories available.</p>
        <?php endif; ?>
    </div>
</section>

<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        var searchTerm = document.getElementById('searchInput').value;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'search_products.php?search=' + encodeURIComponent(searchTerm), true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('productContainer').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });
</script>
