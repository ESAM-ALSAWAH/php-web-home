<?php
session_start();

function respondWithError($statusCode, $message) {
    http_response_code($statusCode);
    echo json_encode(["status" => "error", "message" => $message]);
    exit;
}

function respondWithSuccess($message) {
    echo json_encode(["status" => "success", "message" => $message]);
}

if (!isset($_SESSION['loggedin'])) {
    respondWithError(401, "Unauthorized");
}

if (!isset($_POST['product_id'])) {
    respondWithError(400, "Product ID is missing.");
}

$product_id = intval($_POST['product_id']);

require_once 'config.php';

$sql_get_cart_id = "SELECT id FROM carts WHERE user_id = ?";
$stmt_get_cart_id = mysqli_prepare($conn, $sql_get_cart_id);
mysqli_stmt_bind_param($stmt_get_cart_id, "i", $_SESSION['id']);
mysqli_stmt_execute($stmt_get_cart_id);
mysqli_stmt_store_result($stmt_get_cart_id);

$cart_id = null; // Initialize cart_id variable

if (mysqli_stmt_num_rows($stmt_get_cart_id) > 0) {
    mysqli_stmt_bind_result($stmt_get_cart_id, $cart_id);
    mysqli_stmt_fetch($stmt_get_cart_id);
} else {
    respondWithError(404, "Cart not found for the user.");
}

$sql_check_cart = "SELECT id FROM cart_items WHERE cart_id = ? AND product_id = ?";
$stmt_check_cart = mysqli_prepare($conn, $sql_check_cart);
mysqli_stmt_bind_param($stmt_check_cart, "ii", $cart_id, $product_id);
mysqli_stmt_execute($stmt_check_cart);
mysqli_stmt_store_result($stmt_check_cart);

if (mysqli_stmt_num_rows($stmt_check_cart) > 0) {
    // If the product is already in the cart, remove it
    $sql_remove_cart_item = "DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?";
    $stmt_remove_cart_item = mysqli_prepare($conn, $sql_remove_cart_item);
    mysqli_stmt_bind_param($stmt_remove_cart_item, "ii", $cart_id, $product_id);
    mysqli_stmt_execute($stmt_remove_cart_item);
    mysqli_stmt_close($stmt_remove_cart_item);

    mysqli_close($conn);

    respondWithSuccess("Product removed from cart successfully.");
} else {
    // If the product is not in the cart, add it
    $qty = 1;
    $sql_insert_cart_item = "INSERT INTO cart_items (cart_id, product_id, qty) VALUES (?, ?, ?)";
    $stmt_insert_cart_item = mysqli_prepare($conn, $sql_insert_cart_item);
    mysqli_stmt_bind_param($stmt_insert_cart_item, "iii", $cart_id, $product_id, $qty);
    mysqli_stmt_execute($stmt_insert_cart_item);
    mysqli_stmt_close($stmt_insert_cart_item);

    mysqli_close($conn);

    respondWithSuccess("Product added to cart successfully.");
}
?>
