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

// Execute order insertion
if (mysqli_stmt_execute($stmt_insert_order)) {
    $order_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt_insert_order);

    // Insert order items
    $sql_insert_order_item = "INSERT INTO order_items (order_id, product_id, price) VALUES (?, ?, ?)";
    $stmt_insert_order_item = mysqli_prepare($conn, $sql_insert_order_item);
    mysqli_stmt_bind_param($stmt_insert_order_item, "iid", $order_id, $product_id, $product_price);

    foreach ($order_items as $item) {
        $product_id = $item['product_id'];
        $product_price = $item['price'];
        mysqli_stmt_execute($stmt_insert_order_item);
    }

    mysqli_stmt_close($stmt_insert_order_item);

    // Empty user's cart
    $sql_empty_cart = "DELETE FROM cart_items WHERE cart_id = (SELECT id FROM carts WHERE user_id = ?)";
    $stmt_empty_cart = mysqli_prepare($conn, $sql_empty_cart);
    mysqli_stmt_bind_param($stmt_empty_cart, "i", $user_id);
    if (mysqli_stmt_execute($stmt_empty_cart)) {
        // Check if any rows were affected
        if (mysqli_stmt_affected_rows($stmt_empty_cart) > 0) {
            respondWithSuccess("Order placed successfully and cart emptied.");
        } else {
            respondWithError(500, "Failed to empty the cart.");
        }
    } else {
        // Error handling
        $error_message = mysqli_error($conn);
        respondWithError(500, "Error emptying the cart: " . $error_message);
    }
    mysqli_stmt_close($stmt_empty_cart);
} else {
    // Error handling
    mysqli_stmt_close($stmt_insert_order);
    respondWithError(500, "Failed to create order.");
}

mysqli_close($conn);
?>
