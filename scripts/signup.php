<?php
require_once "./config.php";

$response = ["status" => "error", "message" => "Something went wrong. Please try again later."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"] ?? "");
  $email = filter_var(trim($_POST["email"] ?? ""), FILTER_SANITIZE_EMAIL);
  $password = trim($_POST["password"] ?? "");

  if (empty($username) || empty($email) || empty($password)) {
    http_response_code(400);
    $response = ["status" => "error", "message" => "All fields are required."];
    echo json_encode($response);
    exit;
  }

  // Check if the username is already registered
  $sql = "SELECT id FROM users WHERE username = ?";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_store_result($stmt);
      if (mysqli_stmt_num_rows($stmt) > 0) {
        http_response_code(400);
        $response = ["status" => "error", "message" => "This username is already registered."];
        mysqli_stmt_close($stmt);
        echo json_encode($response);
        exit;
      }
    }
    mysqli_stmt_close($stmt);
  }

  // Check if the email is already registered
  $sql = "SELECT id FROM users WHERE email = ?";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_store_result($stmt);
      if (mysqli_stmt_num_rows($stmt) > 0) {
        http_response_code(400);
        $response = ["status" => "error", "message" => "This email is already registered."];
        mysqli_stmt_close($stmt);
        echo json_encode($response);
        exit;
      }
    }
    mysqli_stmt_close($stmt);
  }

  // Insert new user
  $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
  if ($stmt = mysqli_prepare($conn, $sql)) {
    $param_password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $param_password);
    if (mysqli_stmt_execute($stmt)) {
      // Get the ID of the newly inserted user
      $user_id = mysqli_insert_id($conn);

      // Insert a new record into the carts table for the user
      $sql_cart = "INSERT INTO carts (user_id) VALUES (?)";
      $stmt_cart = mysqli_prepare($conn, $sql_cart);
      mysqli_stmt_bind_param($stmt_cart, "i", $user_id);
      mysqli_stmt_execute($stmt_cart);
      mysqli_stmt_close($stmt_cart);

      $response = ["status" => "success", "message" => "Registration completed successfully. Login to continue."];
    } else {
      http_response_code(500);
      $response = ["status" => "error", "message" => "Something went wrong. Please try again later."];
    }
    mysqli_stmt_close($stmt);
  } else {
    http_response_code(500);
    $response = ["status" => "error", "message" => "Something went wrong. Please try again later."];
  }

  mysqli_close($conn);
}

header('Content-Type: application/json');
echo json_encode($response);
?>
