<?php 
require "./scripts/config.php";

session_start();

if ( !isset($_SESSION["loggedin"]) ) {
  header("Location: ./login.php");
  exit;
}

$user_id = $_SESSION['id'];

// Get the cart ID for the user
$cart_id_query = $conn->prepare("SELECT id FROM carts WHERE user_id = ?");
$cart_id_query->bind_param("i", $user_id);
$cart_id_query->execute();
$cart_id_query->bind_result($cart_id);
$cart_id_query->fetch();
$cart_id_query->close();

// Get the cart items for the user's cart, including the product ID
$cart_items_query = $conn->prepare("SELECT products.id, products.title, products.img, products.price, cart_items.qty 
                                    FROM cart_items 
                                    JOIN products ON cart_items.product_id = products.id 
                                    WHERE cart_items.cart_id = ?");
$cart_items_query->bind_param("i", $cart_id);
$cart_items_query->execute();
$cart_items_query->bind_result($product_id, $title, $img, $price, $qty);

$cart_items = [];
while ($cart_items_query->fetch()) {
    $cart_items[] = [
        'product_id' => $product_id,
        'title' => $title,
        'img' => $img,
        'price' => $price,
        'qty' => $qty
    ];
}
$cart_items_query->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart</title>
    <script src="./lib/tailwind.js"></script>
    <link rel="stylesheet" href="./css/main.css" />
    <link
      rel="shortcut icon"
      href="./img/favicon-16x16.png"
      type="image/x-icon"
    />
    <link rel="stylesheet" href="css/cart.css" />
    <link rel="icon" href="assets/imgs/cart/favicon.png" />
  </head>

  <body>
    <!-- stat up -->
    <div class="up scrollUp z-[1000000000]">
      <div class="container-ms">
        <svg
          width="25"
          height="25"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M7 14l5-5 5 5" stroke="#fff" stroke-width="2" fill="none" />
          <path d="M7 20l5-5 5 5" stroke="#fff" stroke-width="2" fill="none" />
        </svg>
      </div>
    </div>

    <div class="main-header">
      <div class="container-sm">
        <nav>
          <a href="./" class="text-white font-semibold cursor-pointer">Home</a>

          <div class="header-info">
            <a href="#">
              <svg
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"
                  stroke="#fff"
                  stroke-width="3"
                  fill="none"
                ></path>
              </svg>
            </a>
            <a href="#">
              <svg
                class="w-6 h-6 text-gray-800 dark:text-white"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="30"
                height="30"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  d="M12.268 6A2 2 0 0 0 14 9h1v1a2 2 0 0 0 3.04 1.708l-.311 1.496a1 1 0 0 1-.979.796H8.605l.208 1H16a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L4.686 5H4a1 1 0 0 1 0-2h1.5a1 1 0 0 1 .979.796L6.939 6h5.329Z"
                ></path>
                <path
                  d="M18 4a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0V8h2a1 1 0 1 0 0-2h-2V4Z"
                ></path>
              </svg>
            </a>
            <a href="#">
              <svg
                class="w-6 h-6 text-gray-800 dark:text-white"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke="currentColor"
                  stroke-width="1.9"
                  d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                />
              </svg>
            </a>
            <a href="#" class="show">
              <svg
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <rect y="4" width="24" height="2" fill="#7B3B3B" />
                <rect y="11" width="24" height="2" fill="#7B3B3B" />
                <rect y="18" width="24" height="2" fill="#7B3B3B" />
              </svg>
            </a>
          </div>
        </nav>
      </div>
    </div>

    <!-- -------------------------------------- -->

    <section>
      <h1>Your Shoping Cart</h1>
      <div class="text">
        <a href="#">
          <svg
            style="display: inline"
            class="w-6 h-6 text-gray-800 dark:text-white"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            fill="none"
            viewBox="0 0 24 24"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"
            />
          </svg>
          <span>HOME</span>
        </a>
        <p><span>/</span> Your Shoping Cart</p>
      </div>
    </section>

    <!-- -------------------------------------- -->

    <div class="wishlist">
      <h1 class="header">Your Cart Items</h1>
      <svg
        width="64"
        height="24"
        viewBox="0 0 64 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <rect x="0" y="11" width="16" height="2" rx="1" fill="#7B3B3B" />
        <rect x="24" y="7" width="2" height="10" rx="1" fill="#7B3B3B" />
        <rect x="30" y="5" width="2" height="14" rx="1" fill="#7B3B3B" />
        <rect x="36" y="7" width="2" height="10" rx="1" fill="#7B3B3B" />
        <rect x="48" y="11" width="16" height="2" rx="1" fill="#7B3B3B" />
      </svg>
      <div class="container-sm">
        <div class="content">
          <div class="section">
            <div class="row one">
              <span class="w-[170px]">Product Name </span>
              <span>Price </span>
              <span>Delete</span>
            </div>

            <div id="cart-list">
              <?php foreach ($cart_items as $item): ?>
              <div class="row two">
                <span data-lable="Product Name ">
                  <span>
                    <img
                      class="inline-block h-[60px]"
                      src="<?php echo $item['img']; ?>"
                      alt=""
                    />
                    <?php echo $item['title']; ?>
                  </span>
                </span>
                <span data-lable="price">$<?php echo $item['price']; ?> </span>
                <span
                  id="remove-from-cart"
                  data-product-id="<?php echo htmlspecialchars($item['product_id']); ?>"
                  class="cursor-pointer"
                  data-lable="Delete"
                >
                  <div class="bg-[#FFD6D6] rounded-[50%] p-[10px]">
                    <svg
                      width="23"
                      height="23"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M9 3V4H4V6H20V4H15V3H9ZM6 8V20C6 21.1 6.9 22 8 22H16C17.1 22 18 21.1 18 20V8H6ZM9 10H11V18H9V10ZM13 10H15V18H13V10Z"
                        fill="#FF4D4D"
                      />
                    </svg>
                  </div>
                </span>
              </div>
              <?php endforeach; ?>
            </div>

            <!-- <button class="bg-black text-white" id="buton">return</button> -->
            <div class="cart-btn-area">
              <div class="shoping-cart">
                <div class="right">
                  <a class="buton" href="#"> CONTINUE SHOPPING </a>
                  <a class="buton" href="#"> UPDATE SHOPPING CART </a>
                </div>
                <div class="left">
                  <a class="buton" href="#"> UPDATE SHOPPING CART </a>
                </div>
              </div>
            </div>
            <div class="cart">
              <div class="cart-total">
                <div class="order-summery">
                  <div class="order-summery__one">
                    <h6 class="order-summery__title">Subtotal</h6>
                    <span class="order-summery__number">$24000.00</span>
                  </div>
                  <div class="order-summery__two">
                    <h6 class="order-summery__title-two">Grand Total :</h6>
                    <span class="order-summery__number-two">$24000.00</span>
                  </div>
                  <div class="checkout">
                    <a href="check-out.html" class="btn btn--base pill"
                      >PROCEED TO CHECKOUT</a
                    >
                    <p class="checkout__desc">
                      Checkout With Multiple Addresses
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="./js/cart.js"></script>
  </body>
</html>