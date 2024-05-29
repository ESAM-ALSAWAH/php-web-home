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

mysqli_close($conn);
?>
