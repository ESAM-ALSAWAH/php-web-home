// Script for handling DOMContentLoaded event
document.addEventListener("DOMContentLoaded", function () {
  var productButtons = document.querySelectorAll(
    "#product-list button[data-product-id]"
  );

  productButtons.forEach(function (button) {
    button.addEventListener("click", handleCartAction);
  });
});

// Function to handle cart actions
function handleCartAction(event) {
  event.preventDefault();

  var button = this;
  var productId = button.getAttribute("data-product-id");
  var isAddAction = button.getAttribute("id") === "add-to-cart";

  var url = "scripts/add_to_cart.php";
  var buttonText = isAddAction ? "Remove from Cart" : "Add to Cart";
  var successMessage = isAddAction
    ? "Product added to cart successfully."
    : "Product removed from cart successfully.";

  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "product_id=" + productId,
  })
    .then((response) => {
      if (response.ok) {
        console.log(successMessage);
        updateButton(button, isAddAction, buttonText);
        return response.json();
      } else if (response.status === 401) {
        return response.json();
      } else {
        console.error("Error:", response.statusText);
      }
    })
    .then((data) => {
      if (data && data.message == "Unauthorized") {
        window.location.assign("login.php");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// Function to update button after cart action
function updateButton(button, isAddAction, buttonText) {
  button.innerText = buttonText;
  button.id = isAddAction ? "remove-from-cart" : "add-to-cart";
  button.classList.toggle("btn-primary");
  button.classList.toggle("btn-secondary");
  button.removeEventListener("click", handleCartAction);
  button.addEventListener("click", handleCartAction);
}
