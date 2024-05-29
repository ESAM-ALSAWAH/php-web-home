<?php 
$data = include 'scripts/orders.php';
$user_orders = $data['user_orders'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="./lib/tailwind.js"></script>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="icon" href="assets/imgs/cart/favicon.png">
</head>
<body>
    <div class="up scrollUp z-[1000000000] fixed bottom-5 grid place-items-center">
        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 14l5-5 5 5" stroke="#fff" stroke-width="2" fill="none"></path>
            <path d="M7 20l5-5 5 5" stroke="#fff" stroke-width="2" fill="none"></path>
        </svg>
    </div>

    <div class="bg-[#804d4e]">
        <div class="container-sm">
            <nav class="flex justify-between items-center py-2">
                <a href="./" class="text-white font-semibold cursor-pointer">Home</a>
                <div class="flex items-center gap-3">
                    <a href="./cart.php">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.268 6A2 2 0 0 0 14 9h1v1a2 2 0 0 0 3.04 1.708l-.311 1.496a1 1 0 0 1-.979.796H8.605l.208 1H16a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L4.686 5H4a1 1 0 0 1 0-2h1.5a1 1 0 0 1 .979.796L6.939 6h5.329Z"></path>
                            <path d="M18 4a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0V8h2a1 1 0 1 0 0-2h-2V4Z"></path>
                        </svg>
                    </a>
                    <a href="#">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="1.9" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                        </svg>
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <section>
        <h1>Your Orders</h1>
        <div class="text">
            <a href="./index.php">
                <svg style="display: inline" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"></path>
                </svg>
                <span>HOME</span>
            </a>
            <p><span>/</span> Your Orders</p>
        </div>
    </section>

    <div class="wishlist">
        <h1 class="header">Your Orders History</h1>
        <svg width="64" height="24" viewBox="0 0 64 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="0" y="11" width="16" height="2" rx="1" fill="#7B3B3B"></rect>
            <rect x="24" y="7" width="2" height="10" rx="1" fill="#7B3B3B"></rect>
            <rect x="30" y="5" width="2" height="14" rx="1" fill="#7B3B3B"></rect>
            <rect x="36" y="7" width="2" height="10" rx="1" fill="#7B3B3B"></rect>
            <rect x="48" y="11" width="16" height="2" rx="1" fill="#7B3B3B"></rect>
        </svg>
        <div class="container-sm">
            <div class="content">
                <div class="section">
                    <div class="p-[22px] mb-5 flex justify-between items-center bg-white text-sm sm:text-lg font-semibold text-[#333] border border-[rgba(222, 222, 222, 0.478)] rounded-md">
                        <span class="flex-1">Order ID</span>
                        <span class="flex-1">Total Amount</span>
                        <span class="flex-1">Order Date</span>
                    </div>
                    <div id="order-list">
                        <?php foreach ($user_orders as $item): ?>
                        <div class="p-[22px] mb-5 flex justify-between items-center bg-white text-sm sm:text-lg font-semibold text-[#333] border border-[rgba(222, 222, 222, 0.478)] rounded-md">
                            <span class="flex-1"><?php echo htmlspecialchars($item['order_id']); ?></span>
                            <span class="flex-1">$<?php echo htmlspecialchars($item['total_amount']); ?></span>
                            <span class="flex-1"><?php echo htmlspecialchars($item['order_date']); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/order.js"></script>
</body>
</html>
