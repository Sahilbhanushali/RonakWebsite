$(document).ready(function () {
  $("#contact-form-2").on("submit", function (e) {
    e.preventDefault();

    // Basic client-side validation
    if (!$(this)[0].checkValidity()) {
      return false;
    }

    $("#formSubmitButton").attr("disabled", "disabled");
    $("#loader").show();

    $.ajax({
      url: "mail.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "text", // Expect plain text response
      success: function (response) {
        console.log("Response:", response);
        $("#loader").hide();
        $(".theme-btn-s5").prop("disabled", false);

        if (response.trim() === "success") {
          $("#success").show().fadeOut(5000);
          $("#contact-form-2")[0].reset(); // Reset form on success
        } else {
          $("#error")
            .html("Error: " + response)
            .show()
            .fadeOut(5000);
        }
      },
      error: function (xhr, status, error) {
        $("#loader").hide();
        $(".theme-btn-s5").prop("disabled", false);
        $("#error")
          .html("Request failed: " + error)
          .show()
          .fadeOut(5000);
      },
    });
  });
});
$(document).ready(function () {
  $("#contact-form").on("submit", function (e) {
    e.preventDefault();

    // Basic client-side validation
    if (!$(this)[0].checkValidity()) {
      return false;
    }

    $("#formSubmitButton").attr("disabled", "disabled");
    $("#loader").show();

    $.ajax({
      url: "mail2.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "text",
      success: function (response) {
        console.log("Response:", response);
        $("#loader").hide();
        $(".theme-btn-s5").prop("disabled", false);

        if (response.trim() === "success") {
          $("#success").show().fadeOut(5000);
          $("#contact-form")[0].reset(); // Reset form on success
        } else {
          $("#error")
            .html("Error: " + response)
            .show()
            .fadeOut(5000);
        }
      },
      error: function (xhr, status, error) {
        $("#loader").hide();
        $(".theme-btn-s5").prop("disabled", false);
        $("#error")
          .html("Request failed: " + error)
          .show()
          .fadeOut(5000);
      },
    });
  });
});
