let up = document.querySelector(".up");
let mainHeader = document.querySelector(".main-header");

up.addEventListener("click", () => {
  window.scrollTo(0, 0);
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

const orderButton = document.getElementById("order-now");

orderButton.addEventListener("click", function () {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Order Now!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Send a POST request to the PHP script
      fetch("scripts/create_order.php", {
        method: "POST",
      })
        .then((response) => {
          if (response.ok) {
            Swal.fire({
              icon: "success",
              title: "Order Placed Successfully!",
              showConfirmButton: false,
              timer: 1500,
            }).then(() => {
              document.getElementById("cart-list").innerHTML = "";
            });
          } else {
            return response.json().then((data) => {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.message,
              });
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          });
        });
    }
  });
});
