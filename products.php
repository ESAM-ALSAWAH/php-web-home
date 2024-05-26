<?php
$data = include 'scripts/products.php';
$isLogin = $data['isLogin'];
$products = $data['products'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pet Shop | Products</title>
    <script src="./lib/tailwind.js"></script>
    <script defer src="./js/index.js"></script>
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="shortcut icon" href="./img/favicon-16x16.png" type="image/x-icon" />
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
              '<a href="./cart.php" title="Cart">
                <div class="cart-badge">
                  <svg class="transition-all duration-300 w-8 h-8 text-[#333333] hover:text-[#33c1c1]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z" clip-rule="evenodd" />
                  </svg>
                </div>
              </a>' : null;
            ?>
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
            <h1 class="text-[#333333] font-[800] mb-10 --heading-one leading-tight">
              Everything your pet needs
            </h1>
            <button class="btn-primary">SHOP NOW</button>
          </div>
          <div class="flex-1 hidden md:flex md:justify-end">
            <img src="./assets/imgs/hero-image.png" alt="pet" class="object-cover" />
          </div>
        </div>
      </div>
    </div>

    <!--  products -->
    <div class="container-sm py-20">
      <div class="heading flex flex-col items-center justify-center gap-2">
        <img src="./assets/imgs/heading-img.png" alt="heading-img">
        <div class="flex items-center justify-center gap-20 w-full">
          <div class="h-[2px] flex-1 bg-[#ddd]"></div>
          <h1 class="text-center --heading-three text-[#333333] font-bold">All Products</h1>
          <div class="h-[2px] flex-1 bg-[#ddd]"></div>
        </div>
      </div>
      <div id="product-list" class="mt-10">
        <div class="flex items-center justify-center flex-wrap gap-10">
    <?php if (!empty($products)) : ?>
    <?php foreach ($products as $product) : ?>
        <div class="product-card relative min-w-[250px] max-w-[270px] w-full grid place-items-center gap-2 bg-white border rounded-lg py-5 px-5">
            <div class="absolute top-2 right-2 cursor-pointer">
                <svg class="w-6 h-6 text-[#33C1C1] " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd"/>
</svg>

            </div>
            <img src="<?php echo htmlspecialchars($product['img']); ?>" class="w-auto h-[200px] max-w-[200px]" alt="<?php echo htmlspecialchars($product['title']); ?>">
            <h5 class="text-lg"><?php echo htmlspecialchars($product['title']); ?></h5>
            <h6 class="font-bold">$<?php echo htmlspecialchars($product['price']); ?></h6>
            <?php if ($product['isAdded']) : ?>
                <button id="remove-from-cart" data-product-id="<?php echo htmlspecialchars($product['id']); ?>" class="btn-secondary py-[4px]">Remove from Cart</button>
            <?php else : ?>
                <button id="add-to-cart" data-product-id="<?php echo htmlspecialchars($product['id']); ?>" class="btn-primary py-[4px]">Add to Cart</button>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <p>No trending products found.</p>
<?php endif; ?>

        </div>
      </div>
      
    </div>

    <!-- ------- -->



    <footer class="mt-[200px]">
      <div class="hidden sm:flex container-sm z-30 px-20 absolute -top-[5vh] md:-top-[8vh] left-1/2 -translate-x-1/2">
        <img src="./assets/imgs/footer-image.png" class="mx-auto w-full max-w-[1100px]">
      </div>
      <div class="h-full flex items-center justify-center md:hidden absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <h1 class="font-bold text-2xl">
          PetShop<span class="text-[#33c1c1] text-6xl">.</span>
        </h1>
      </div>
    </footer>
  </body>
</html>
