<?php
require "config.php";
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION["loggedin"])) {
    header("Location: ./login.php");
    exit;
}

$user_id = $_SESSION['id'];

// Get the cart ID and cart items for the user
$cart_items = [];

if ($stmt = $conn->prepare("
    SELECT ci.product_id, p.title, p.img, p.price, ci.qty 
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    JOIN carts c ON ci.cart_id = c.id
    WHERE c.user_id = ?
")) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($product_id, $title, $img, $price, $qty);

    while ($stmt->fetch()) {
        $cart_items[] = [
            'product_id' => $product_id,
            'title' => $title,
            'img' => $img,
            'price' => $price,
            'qty' => $qty
        ];
    }

    $stmt->close();
}

$conn->close();
return [
    'cart_items' => $cart_items,
];
?>
