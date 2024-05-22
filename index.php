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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pet Shop</title>
    <script src="./lib/tailwind.js"></script>
    <link rel="stylesheet" href="./css/main.css" />
    <link
      rel="shortcut icon"
      href="./img/favicon-16x16.png"
      type="image/x-icon"
    />
  </head>

  <body>
    <nav class="bg-white py-4">
      <div class="container-sm">
        <div class="flex justify-between items-center">
          <h1 class="font-bold text-2xl">
            PetShop<span class="text-[#33c1c1] text-4xl">.</span>
          </h1>

          <div class="flex items-center gap-4">
            <?php
                echo $isLogin ?
           ' <a href="./cart.php" title="Cart">
              <div class="cart-badge">
                <svg
                  class="transition-all duration-300 w-8 h-8 text-[#333333] hover:text-[#33c1c1]"
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
            </a>':null ;?>

              <?php
                echo $isLogin ?
                    '<a href="./logout.php" class="" title="Logout">
                      <svg class="transition-all duration-300 w-8 h-8 text-[#333333] hover:text-[#33c1c1]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
</svg>

                    </a>' :
                    '<a href="./login.php" class="btn-primary py-2 rounded-lg">SignIn</a>';
                ?>
          </div>
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
            <h1
              class="text-[#333333] font-[800] mb-10 --heading-one leading-tight"
            >
              Everything your pet need
            </h1>

            <button class="btn-primary">SHOP NOW</button>
          </div>
          <div class="flex-1 hidden md:flex md:justify-end">
            <img
              src="./assets/imgs/hero-image.png"
              alt="pet"
              class="object-cover"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="container-sm py-20">
      <div class="flex flex-col sm:grid grid-cols-2 gap-4">
          <img src="/assets/imgs/card-1.png" alt="card-1">
        <div class="flex flex-col gap-4 sm:gap-1 sm:grid grid-cols-1">
          <img src="/assets/imgs/card-2.png" alt="card-2">
          <img src="/assets/imgs/card-3.png" alt="card-3">

        </div>
      </div>
    </div>
    <div class="container-sm py-10">
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
         <div class="flex flex-col justify-center gap-1">
          <img src="/assets/icons/shooping.png" width="40" height="40" class="mx-auto" />
          <p class="text-[#333] text-sm font-semibold text-center">FREE SHIPPING</p>
          <p class="text-[#787878] text-xs font-semibold text-center">For All Order Over $99</p>
         </div>
         <div class="flex flex-col justify-center gap-1">
          <img src="/assets/icons/support.png" width="40" height="40" class="mx-auto" />
          <p class="text-[#333] text-sm font-semibold text-center">FRIENDLY SUPPORT</p>
          <p class="text-[#787878] text-xs font-semibold text-center">24/7 Customer Support</p>
         </div>
         <div class="flex flex-col justify-center gap-1">
          <img src="/assets/icons/secure.png" width="40" height="40" class="mx-auto" />
          <p class="text-[#333] text-sm font-semibold text-center">SECURE PAYMENT</p>
          <p class="text-[#787878] text-xs font-semibold text-center">100% Secure Payment</p>
         </div>
         <div class="flex flex-col justify-center gap-1">
          <img src="/assets/icons/return.png" width="40" height="40" class="mx-auto" />
          <p class="text-[#333] text-sm font-semibold text-center">SHIPPING & RETURN</p>
          <p class="text-[#787878] text-xs font-semibold text-center">within 30days For Refund</p>
         </div>
      </div>
    </div>


    <footer class="mt-[100px] ">
      <img src="/assets/imgs/footer-top-shape.png" class="absolute -z-10 -top-[30px] w-full">
      <div class="container-sm z-30 absolute -top-[10%]  left-1/2 -translate-x-1/2">
      <img src="/assets/imgs/footer-image.png" class=" mx-auto w-full ">
</div>
    </footer>
  </body>
</html>
