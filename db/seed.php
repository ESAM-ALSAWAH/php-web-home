<?php
$servername = "localhost";
$username = "root";
$password = ""; // Use your database password
$dbname = "store"; // Use your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of products to insert
$products = [
    ["title" => "Product 1", "img" => "./assets/imgs/products/arrival-two03.png", "description" => "Description for product 1", "price" => 19.99, "is_trend" => true],
    ["title" => "Product 2", "img" => "./assets/imgs/products/arrival-two04.png", "description" => "Description for product 2", "price" => 29.99, "is_trend" => true],
    ["title" => "Product 3", "img" => "./assets/imgs/products/product05.png", "description" => "Description for product 3", "price" => 39.99, "is_trend" => true],
    ["title" => "Product 4", "img" => "./assets/imgs/products/product08.png", "description" => "Description for product 4", "price" => 49.99, "is_trend" => true],
    ["title" => "Product 5", "img" => "img/product5.jpg", "description" => "Description for product 5", "price" => 9.99, "is_trend" => false],
    ["title" => "Product 6", "img" => "img/product6.jpg", "description" => "Description for product 6", "price" => 25.99, "is_trend" => false],
    ["title" => "Product 7", "img" => "img/product7.jpg", "description" => "Description for product 7", "price" => 15.99, "is_trend" => false],
    ["title" => "Product 8", "img" => "img/product8.jpg", "description" => "Description for product 8", "price" => 45.00, "is_trend" => false],
    ["title" => "Product 9", "img" => "img/product9.jpg", "description" => "Description for product 9", "price" => 99.99, "is_trend" => false],
    ["title" => "Product 10", "img" => "img/product10.jpg", "description" => "Description for product 10", "price" => 75.00, "is_trend" => false],
    ["title" => "Product 11", "img" => "img/product11.jpg", "description" => "Description for product 11", "price" => 29.95, "is_trend" => false],
    ["title" => "Product 12", "img" => "img/product12.jpg", "description" => "Description for product 12", "price" => 19.99, "is_trend" => false],
    ["title" => "Product 13", "img" => "img/product13.jpg", "description" => "Description for product 13", "price" => 59.99, "is_trend" => false],
    ["title" => "Product 14", "img" => "img/product14.jpg", "description" => "Description for product 14", "price" => 11.49, "is_trend" => false],
    ["title" => "Product 15", "img" => "img/product15.jpg", "description" => "Description for product 15", "price" => 23.99, "is_trend" => false],
    ["title" => "Product 16", "img" => "img/product16.jpg", "description" => "Description for product 16", "price" => 89.99, "is_trend" => false],
    ["title" => "Product 17", "img" => "img/product17.jpg", "description" => "Description for product 17", "price" => 33.33, "is_trend" => false],
    ["title" => "Product 18", "img" => "img/product18.jpg", "description" => "Description for product 18", "price" => 49.49, "is_trend" => false],
    ["title" => "Product 19", "img" => "img/product19.jpg", "description" => "Description for product 19", "price" => 65.65, "is_trend" => false],
    ["title" => "Product 20", "img" => "img/product20.jpg", "description" => "Description for product 20", "price" => 12.99, "is_trend" => false],
];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO products (title, img, description, price, is_trend) VALUES (?, ?, ?, ?, ?)");

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameters
$stmt->bind_param("sssdi", $title, $img, $description, $price, $is_trend);

// Loop through the products array and insert each product
foreach ($products as $product) {
    $title = $product["title"];
    $img = $product["img"];
    $description = $product["description"];
    $price = $product["price"];
    $is_trend = $product["is_trend"];
    $stmt->execute();
}

// Close the statement and connection
$stmt->close();
$conn->close();

echo "Data seeded successfully.";
?>
