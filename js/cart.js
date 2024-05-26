let up = document.querySelector(".up");
let mainHeader = document.querySelector(".main-header");

window.addEventListener("scroll", () => {
  if (window.scrollY >= 200) {
    mainHeader.classList.add("main-header-sticky");
  } else {
    mainHeader.classList.remove("main-header-sticky");
  }
  if (window.scrollY >= 300) {
    up.style.bottom = "+40px";
  } else {
    up.style.bottom = "-40px";
  }

  up.addEventListener("click", () => {
    window.scrollTo(0, 0);
  });
});

var productButtons = document.querySelectorAll(
  "#cart-list span[data-product-id]"
);

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
        // Get the row element and remove it
        var row = button.closest(".row");
        if (row) {
          row.remove();
        }
        return response.json();
      } else if (response.status === 401) {
        return response.json();
      } else {
        console.error("Error:", response.statusText);
      }
    })
    .then((data) => {
      if (data && data.message === "Unauthorized") {
        window.location.assign("login.php");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

productButtons.forEach(function (button) {
  button.addEventListener("click", handleCartAction);
});