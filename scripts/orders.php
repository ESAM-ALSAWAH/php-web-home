<?php
require "config.php";
session_start();

if (!isset($_SESSION["loggedin"])) {
    header("Location: ./login.php");
    exit;
}

$user_id = $_SESSION['id'];

// Get the user orders
$user_orders = [];

if ($stmt = $conn->prepare("
    SELECT o.id, o.total_amount, o.order_date 
    FROM orders o
    WHERE o.user_id = ?
")) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($order_id, $total_amount, $order_date);

    while ($stmt->fetch()) {
        $user_orders[] = [
            'order_id' => $order_id,
            'total_amount' => $total_amount,
            'order_date' => $order_date
        ];
    }

    $stmt->close();
}

$conn->close();

// Return the user orders as an array
return ['user_orders' => $user_orders];
?>
