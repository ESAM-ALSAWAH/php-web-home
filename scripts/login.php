<?php
# Initialize session
session_start();

# Include connection
require_once "./config.php";

# Define variables and initialize with empty values
$login_err = "";

# Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["user_login"])) || empty(trim($_POST["user_password"]))) {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Please enter your username or email and password."]);
    exit;
  } else {
    $user_login = trim($_POST["user_login"]);
    $user_password = trim($_POST["user_password"]);

    # Prepare a select statement
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
      # Bind variables to the statement as parameters
      mysqli_stmt_bind_param($stmt, "ss", $param_user_login, $param_user_login);

      # Set parameters
      $param_user_login = $user_login;

      # Execute the statement
      if (mysqli_stmt_execute($stmt)) {
        # Store result
        mysqli_stmt_store_result($stmt);

        # Check if user exists, If yes then verify password
        if (mysqli_stmt_num_rows($stmt) == 1) {
          # Bind values in result to variables
          mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

          if (mysqli_stmt_fetch($stmt)) {
            # Check if password is correct
            if (password_verify($user_password, $hashed_password)) {

              # Store data in session variables
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["loggedin"] = TRUE;

              http_response_code(200); // OK
              echo json_encode(["status" => "success", "message" => "Login successful"]);
              exit;
            } else {
              # If password is incorrect show an error message
              $login_err = "The email or password you entered is incorrect.";
            }
          }
        } else {
          # If user doesn't exists show an error message
          $login_err = "Invalid username or password.";
        }
      } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Oops! Something went wrong. Please try again later."]);
        exit;
      }

      # Close statement
      mysqli_stmt_close($stmt);
    }
  }

  # Close connection
  mysqli_close($conn);

  # Send a JSON response with appropriate error message
  http_response_code(401); // Unauthorized
  echo json_encode(["message" => $login_err]);
  exit;
}
?>
