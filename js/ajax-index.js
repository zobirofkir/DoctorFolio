$(document).ready(function () {
    $("#contactForm").submit(function (event) {
        event.preventDefault();

        var submitButton = $("#submitButton");
        submitButton.prop("disabled", true);
        submitButton.html("Sending...");

        var message = $("#message").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var PhoneNumber = $("#PhoneNumber").val();

        $.ajax({
            method: "POST",
            url: "http://localhost:3000/DoctorFolio/php/Contact-index.php",
            data: {
                contact: true,
                message: message,
                PhoneNumber: PhoneNumber,
                email: email,
                username: username,
            },
            success: function(response) {
                console.log(response);
                if (response === "We call you soon") {
                    // Show success message to the user
                    var successMessage = "Success! We will call you soon.";
                    $("#statusMessage").html("<p style='color: green; font-weight: bold;'>" + successMessage + "</p>");
                    $("#statusMessage").addClass("success");
                    $("#statusMessage").removeClass("error");
                    
                    // Display email in alert
                    alert("We will call you soon: " + email);
                } else {
                    // Show error message to the user
                    $("#statusMessage").html("An error occurred while processing your request.");
                    $("#statusMessage").addClass("error");
                    $("#statusMessage").removeClass("success");
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                // Show error message to the user
                $("#statusMessage").html("An error occurred while making the request.");
                $("#statusMessage").addClass("error");
                $("#statusMessage").removeClass("success");
            },
            complete: function() {
                submitButton.prop("disabled", false);
                submitButton.html("Send");
            }
        });
    });
});
