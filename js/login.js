document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  const loginSubmitButton = document.getElementById("login-submit");

  loginSubmitButton.addEventListener("click", async (e) => {
    const formData = new FormData(form);

    try {
      const response = await fetch("scripts/login.php", {
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
        title: "Login Successfully",
        text: result.message,
        icon: "success",
        confirmButtonText: "Close",
      });
      if (result.status === "success") {
        window.location.href = "./";
      }
    } catch (error) {
      Swal.fire({
        title: "Error!",
        text: error.message,
        icon: "error",
        confirmButtonText: "Close",
      });
    }
  });
});
