
<?php 
ob_start();
  session_start();

if (isset($_SESSION["loggedin"]) ) {
  header("Location: ./");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Registration</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/main.css" />
    <link
      rel="shortcut icon"
      href="./img/favicon-16x16.png"
      type="image/x-icon"
    />
    <script defer src="./js/signup.js"></script>
  </head>

  <body>
    <div class="container">
      <div class="row min-vh-100 justify-content-center align-items-center">
        <div class="col-lg-5">
          <div class="form-wrap border rounded p-4">
            <h1>Sign Up</h1>
            <p>Please fill this form to register</p>
            <form novalidate>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                  type="text"
                  class="form-control"
                  name="username"
                  id="username"
                />
                <small class="text-danger"></small>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input
                  type="email"
                  class="form-control"
                  name="email"
                  id="email"
                />
                <small class="text-danger"></small>
              </div>
              <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input
                  type="password"
                  class="form-control"
                  name="password"
                  id="password"
                />
                <small class="text-danger"></small>
              </div>
              <div class="mb-3 form-check">
                <input
                  type="checkbox"
                  class="form-check-input"
                  id="togglePassword"
                />
                <label for="togglePassword" class="form-check-label"
                  >Show Password</label
                >
              </div>
              <div class="mb-3">
                <input
                  type="submit"
                  class="btn btn-primary form-control"
                  name="submit"
                  value="Sign Up"
                />
              </div>
              <p class="mb-0">
                Already have an account? <a href="./login.php">Log In</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
