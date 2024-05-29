<?php
require "config.php";
session_start();

function respondWithError($statusCode, $message) {
    http_response_code($statusCode);
    echo json_encode(["status" => "error", "message" => $message]);
    exit;
}

function respondWithSuccess($message) {
    http_response_code(200);
    echo json_encode(["status" => "success", "message" => $message]);
}

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    respondWithError(401, "Unauthorized");
}

$user_id = $_SESSION['id'];

// Retrieve user's cart items
$sql_cart_items = "SELECT product_id FROM cart_items WHERE cart_id = (SELECT id FROM carts WHERE user_id = ?)";
$stmt_cart_items = mysqli_prepare($conn, $sql_cart_items);
mysqli_stmt_bind_param($stmt_cart_items, "i", $user_id);
mysqli_stmt_execute($stmt_cart_items);
$result_cart_items = mysqli_stmt_get_result($stmt_cart_items);

if (mysqli_num_rows($result_cart_items) === 0) {
    respondWithError(404, "No items found in the cart.");
}

$order_total = 0;
$order_items = [];

// Prepare order items
while ($row = mysqli_fetch_assoc($result_cart_items)) {
    $product_id = $row['product_id'];

    // Retrieve product price
    $sql_product_price = "SELECT price FROM products WHERE id = ?";
    $stmt_product_price = mysqli_prepare($conn, $sql_product_price);
    mysqli_stmt_bind_param($stmt_product_price, "i", $product_id);
    mysqli_stmt_execute($stmt_product_price);
    $result_product_price = mysqli_stmt_get_result($stmt_product_price);
    $product_price = mysqli_fetch_assoc($result_product_price)['price'];

    $order_total += $product_price;
    $order_items[] = [
        'product_id' => $product_id,
        'price' => $product_price
    ];

    mysqli_stmt_close($stmt_product_price);
}

// Insert new order
$sql_insert_order = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
$stmt_insert_order = mysqli_prepare($conn, $sql_insert_order);
mysqli_stmt_bind_param($stmt_insert_order, "id", $user_id, $order_total);

$result = mysqli_stmt_execute($stmt_insert_order);

// Check if order insertion was successful
if ($result) {
    // Retrieve cart ID
    $sql_get_cart_id = "SELECT id FROM carts WHERE user_id = ?";
    $stmt_get_cart_id = mysqli_prepare($conn, $sql_get_cart_id);
    mysqli_stmt_bind_param($stmt_get_cart_id, "i", $user_id);
    mysqli_stmt_execute($stmt_get_cart_id);
    mysqli_stmt_bind_result($stmt_get_cart_id, $cart_id);
    mysqli_stmt_fetch($stmt_get_cart_id);
    mysqli_stmt_close($stmt_get_cart_id);

    if (!$cart_id) {
        respondWithError(404, "Cart not found for the user.");
    }

    // Empty cart
    $sql_empty_cart = "DELETE FROM cart_items WHERE cart_id = ?";
    $stmt_empty_cart = mysqli_prepare($conn, $sql_empty_cart);
    mysqli_stmt_bind_param($stmt_empty_cart, "i", $cart_id);
    if(mysqli_stmt_execute($stmt_empty_cart)) {
        if(mysqli_stmt_affected_rows($stmt_empty_cart) > 0) {
            respondWithSuccess("Order placed successfully and cart emptied.");
        } else {
            respondWithError(500, "Failed to empty the cart.");
        }
    } else {
        $error_message = mysqli_error($conn);
        respondWithError(500, "Error emptying the cart: " . $error_message);
    }
    mysqli_stmt_close($stmt_empty_cart);
} else {
    respondWithError(500, "Error placing the order.");
}

mysqli_stmt_close($stmt_insert_order);
mysqli_close($conn);
?>
