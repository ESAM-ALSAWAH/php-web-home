
<?php 
session_start();
$isLogin=false;
if (isset($_SESSION) && isset($_SESSION["loggedin"]) ) {
  $isLogin=true;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User login system</title>
  <script src="./lib/tailwind.js"></script>
  <link rel="stylesheet" href="./css/main.css">
  <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon">
</head>

<body>
  

<nav class="bg-white py-4">
  <div class="container-sm ">
    <div class="flex justify-between items-center ">
      <h1 class="font-bold text-2xl ">PetShop<span class="text-[#33c1c1] text-4xl ">.</span></h1>

         <?php
                echo $isLogin ?
                    '<a href="./logout.php" class="btn-primary py-2 rounded-lg">Logout</a>' :
                    '<a href="./login.php" class="btn-primary py-2 rounded-lg">SignIn</a>';
                ?>
    </div>
  </div>
</nav>
<div class="hero">
  <div class="container-sm">
    <div class="flex items-center justify-between gap-5">
      <div class="flex-1">
        <h3 class="text-[#33c1c1] text-xl font-bold mb-1.5">
Save 20 -30% Off
        </h3>
        <h1 class="text-[#333333] font-[800] mb-10 --heading-one leading-tight">
          Everything your pet need
        </h1>
       
        <button class="btn-primary">SHOP NOW</button>
      </div>
      <div class="flex-1 hidden md:flex md:justify-end">
        <img src="./assets/imgs/hero-image.png" alt="pet" class="object-cover">
      </div>
    </div>
  </div>
</div>
</body>

</html>
