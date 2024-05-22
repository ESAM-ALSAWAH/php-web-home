document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const registerSubmitButton = document.getElementById("register-submit");
  registerSubmitButton.addEventListener("click", async (e) => {
    const formData = new FormData(form);

    let hasError = false;
    const errors = { username: "", email: "", password: "" };

    const username = formData.get("username").trim();
    const email = formData.get("email").trim();
    const password = formData.get("password").trim();

    if (!username) {
      errors.username = "Please enter a username.";
      hasError = true;
    } else if (!/^[\w@-]+$/.test(username)) {
      errors.username =
        "Username can only contain letters, numbers and symbols like '@', '_', or '-'.";
      hasError = true;
    }

    if (!email) {
      errors.email = "Please enter an email address.";
      hasError = true;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      errors.email = "Please enter a valid email address.";
      hasError = true;
    }

    if (!password) {
      errors.password = "Please enter a password.";
      hasError = true;
    } else if (password.length < 8) {
      errors.password = "Password must contain at least 8 or more characters.";
      hasError = true;
    }

    document.querySelector("#username + small").textContent = errors.username;
    document.querySelector("#email + small").textContent = errors.email;
    document.querySelector("#password + small").textContent = errors.password;

    if (!hasError) {
      try {
        const response = await fetch("scripts/signup.php", {
          method: "POST",
          body: formData,
          headers: {
            Accept: "application/json",
          },
        });

        const result = await response.json();
        if (!response.ok) {
          throw new Error(result.message);
        }

        Swal.fire({
          title: "Register Successfully",
          text: result.message,
          icon: "success",
          confirmButtonText: "Close",
        });
        if (result.status === "success") {
          window.location.href = "./login.php";
        }
      } catch (error) {
        Swal.fire({
          title: "Error!",
          text: error.message,
          icon: "error",
          confirmButtonText: "Close",
        });
      }
    }
  });
});
