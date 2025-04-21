document
  .getElementById("contact-form")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);

    // Add Hostinger-specific anti-spam measure
    formData.append("hostinger_security", new Date().getTime());

    // Show loading state
    const submitBtn = this.querySelector('button[type="submit]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.innerHTML =
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';
    submitBtn.disabled = true;

    // AJAX request
    fetch("mail.php", {
      method: "POST",
      body: formData,
      headers: {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          // Success handling
          const successMsg = document.createElement("div");
          successMsg.className = "alert alert-success mt-3";
          successMsg.innerHTML =
            "Thank you! Your message has been sent successfully.";
          this.parentNode.insertBefore(successMsg, this.nextSibling);
          this.reset();

          // Remove message after 5 seconds
          setTimeout(() => {
            successMsg.remove();
          }, 5000);
        } else {
          throw new Error(data.message || "Unknown error occurred");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        const errorMsg = document.createElement("div");
        errorMsg.className = "alert alert-danger mt-3";
        errorMsg.innerHTML =
          "There was a problem sending your message. Please try again later.";
        this.parentNode.insertBefore(errorMsg, this.nextSibling);

        // Remove message after 5 seconds
        setTimeout(() => {
          errorMsg.remove();
        }, 5000);
      })
      .finally(() => {
        submitBtn.innerHTML = originalBtnText;
        submitBtn.disabled = false;
      });
  });
