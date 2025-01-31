<?php
include('connection.php');

// Get search term
$searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Fetch categories
$categoryQuery = "SELECT * FROM category";
$categoryResult = $conn->query($categoryQuery);

if ($categoryResult && $categoryResult->num_rows > 0) {
    while ($category = $categoryResult->fetch_assoc()) {
        echo '<div class="category-section" style="margin-bottom: 40px;">';
        echo '<h3 class="mt-5 mb-3 fw-bold" style="font-size: 1.5rem; margin-bottom: 20px;">' . htmlspecialchars($category['category_name']) . '</h3>';

        // Pagination logic
        $categoryId = $category['category_id'];
        $limit = 8;
        $page = isset($_GET["page_$categoryId"]) ? (int)$_GET["page_$categoryId"] : 1;
        $offset = ($page - 1) * $limit;

        // Query to fetch paginated products for the category with search filter
        $productQuery = "SELECT * FROM products WHERE category_id = $categoryId AND stock > 0 AND product_name LIKE '%$searchTerm%' LIMIT $limit OFFSET $offset";
        $productResult = $conn->query($productQuery);

        // Query to count total products in this category with search filter
        $countQuery = "SELECT COUNT(*) as total FROM products WHERE category_id = $categoryId AND stock > 0 AND product_name LIKE '%$searchTerm%'";
        $countResult = $conn->query($countQuery);
        $totalProducts = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalProducts / $limit);

        echo '<div class="popular-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px;">';

        if ($productResult->num_rows > 0) {
            while ($product = $productResult->fetch_assoc()) {
                echo '<div class="product-box" style="width: 250px; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; text-align: left; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">';
                echo '<a href="#" class="product-box-img" style="display: block; overflow: hidden; background: transparent;">';
                echo '<img src="uploads/' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['product_name']) . '" style="width: 100%; height: 200px; object-fit: cover;">';
                echo '</a>';
                echo '<div class="product-box-text" style="padding: 15px; height: 100%;">';
                echo '<a href="#" class="product-text-title" style="font-size: 1.1rem; font-weight: bold; color: #FAF0E6; text-decoration: none;">' . htmlspecialchars($product['product_name']) . '</a>';
                echo '<p style="margin: 10px 0; font-size: 0.9rem; color: #B9B4C7;">' . htmlspecialchars($product['description']) . '</p>';
                echo '<p style="margin: 10px 0; font-size: 1rem; color: #F39F5A;">₱' . number_format($product['price'], 2) . '</p>';
                echo '<a href="product_details.php?id=' . $product['product_id'] . '" class="btn btn-primary mt-3 d-flex align-items-center justify-content-center" style="border: none;">';
                echo '<i class="bi bi-cart-plus me-2"></i>Add To Cart';
                echo '</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p style="font-size: 1.2rem; color: #999;">No products available in this category.</p>';
        }

        echo '</div>';

        // Pagination links
        echo '<nav><ul class="pagination justify-content-center mt-4">';
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page_' . $categoryId . '=' . $i . '">' . $i . '</a></li>';
        }
        echo '</ul></nav>';
        echo '</div>';
    }
} else {
    echo '<p style="font-size: 1.2rem; color: #999;">No categories available.</p>';
}
?>
