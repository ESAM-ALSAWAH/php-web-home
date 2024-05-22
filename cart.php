
<?php 
session_start();
if ( !isset($_SESSION["loggedin"]) ) {
  header("Location: ./login.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <script src="./lib/tailwind.js"></script>
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
  
</head>

<body>
  

<nav class="bg-white py-4">
  <div class="container-sm ">
    <div class="flex justify-between items-center ">
        <a href="./index.php">
      <h1 class="font-bold text-2xl ">PetShop<span class="text-[#33c1c1] text-4xl ">.</span></h1>
       <a href="#" title="cart">
              <div class="cart-badge">
                <svg
                  class="w-8 h-8 text-[#333333] "
                  aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg"
                  width="40"
                  height="40"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill-rule="evenodd"
                    d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                    clip-rule="evenodd"
                  />
                </svg>
              </div>
            </a>
      </a>
    </div>
  </div>
</nav>


</body>

</html>
