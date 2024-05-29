<?php 
session_start();
if (isset($_SESSION["loggedin"])) {
    header("Location: ./");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login System</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="icon" href="assets/imgs/cart/favicon.png">
    <script src="lib/tailwind.js"></script>
    <script src="lib/sweetalert.js"></script>
    <script defer src="./js/login.js"></script>
</head>
<body>
    <div class="min-h-screen bg-gray-100 flex flex-col justify-center sm:py-12">
        <div class="container-sm">
            <div class="p-10 xs:p-0 mx-auto md:w-full md:max-w-md">
                <h1 class="font-bold text-2xl text-center mb-2">
                    PetShop<span class="text-[#33c1c1] text-4xl">.</span>
                </h1>
                <div class="bg-white shadow w-full rounded-lg divide-y divide-gray-200">
                    <form id="loginForm" method="post" novalidate class="px-5 py-7">
                        <label class="font-semibold text-sm text-gray-600 pb-1 block" for="user_login">E-mail</label>
                        <input 
                            type="text" 
                            id="user_login" 
                            name="user_login" 
                            class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" 
                        />
                        <label class="font-semibold text-sm text-gray-600 pb-1 block" for="user_password">Password</label>
                        <input 
                            type="password" 
                            id="user_password" 
                            name="user_password" 
                            class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" 
                        />
                        <button
                            id="login-submit"
                            type="button"
                            class="transition duration-200 bg-[#33c1c1] hover:bg-[#33c1c1] focus:bg-[#33c1c1] focus:shadow-sm focus:ring-4 focus:ring-[#33c1c1] focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block"
                        >
                            <span class="inline-block mr-2">Login</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 inline-block">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </form>
                    <div class="py-4">
                        <div class="text-center whitespace-nowrap">
                            <a href="./signup.php" class="text-gray-500 cursor-pointer underline">
                                <span class="inline-block ml-1">Register</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
