<?php
require "config.php";
session_start();

$isLogin = false;
if (isset($_SESSION) && isset($_SESSION["loggedin"])) {
  $isLogin = true;
}

$cart_id = null;
if ($isLogin) {
    $user_id = $_SESSION['id'];

    // Fetch the cart ID for the logged-in user
    $sql_get_cart_id = "SELECT id FROM carts WHERE user_id = ?";
    $stmt_get_cart_id = mysqli_prepare($conn, $sql_get_cart_id);
    mysqli_stmt_bind_param($stmt_get_cart_id, "i", $user_id);
    mysqli_stmt_execute($stmt_get_cart_id);
    mysqli_stmt_bind_result($stmt_get_cart_id, $cart_id);
    mysqli_stmt_fetch($stmt_get_cart_id);
    mysqli_stmt_close($stmt_get_cart_id);
}

$sql = "SELECT p.id, p.title, p.img, p.description, p.price, p.created_at, 
               CASE WHEN ci.product_id IS NOT NULL THEN TRUE ELSE FALSE END AS isAdded
        FROM products p
        LEFT JOIN cart_items ci ON p.id = ci.product_id AND ci.cart_id = ?";

        
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
} else {
    // Handle statement preparation error
    $trendingProducts = [];
}

// Export variables for inclusion in the HTML file
return [
    'isLogin' => $isLogin,
    'products' => $products,
];
?>
