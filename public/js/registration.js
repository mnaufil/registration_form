$(document).ready(function () {
   
    $("#password").on("input", function() {
        var password = $(this).val();
        var strengthBar = $("#strength-bar");
        var feedback = $("#password-feedback");

        var strength = 0;
        if (password.length >= 8) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[@$!%*?&]/.test(password)) strength++;

        if (strength === 0) {
            strengthBar.removeClass("weak medium strong").css("width", "0%");
            feedback.text("");
        } else if (strength === 1) {
            strengthBar.removeClass("medium strong").addClass("weak").css("width", "25%");
            feedback.text("Weak").css("color", "red");
        } else if (strength === 2) {
            strengthBar.removeClass("weak strong").addClass("medium").css("width", "50%");
            feedback.text("Medium").css("color", "orange");
        } else if (strength >= 3) {
            strengthBar.removeClass("weak medium").addClass("strong").css("width", "100%");
            feedback.text("Strong").css("color", "green");
        }
    });

    //checking if name is already taken or not 
    $("#name").on("focus keyup blur", function () {
        var name = $(this).val();
        if (name.length > 2) {
            $.ajax({
                url: "/interview2/checkduplicates.php",
                method: "POST",
                data: { name: name },
                success: function (response) {
                    if (response.trim() !== "") { 
                        $("#name_status").html(response);
                        $("#submit-btn").prop("disabled", true);
                    }else{
                        $("#name_status").html('');
                        $("#submit-btn").prop("disabled", false);
                    }
                }
            });
        }
    });
  
    //checking if email is already taken or not 
    $("#email").on("blur", function () {
        var email = $(this).val();
        if (email.length > 5) {
            $.ajax({
                url: "/interview2/checkduplicates.php",
                method: "POST",
                data: { email: email },
                success: function (response) {

                    if (response.trim() !== "") { 
                        $("#email_status").html(response);
                        $("#submit-btn").prop("disabled", true);
                        $("#submit-btn").css("cursor", "not-allowed");
                    }else{
                        $("#email_status").html();
                        $("#submit-btn").prop("disabled", false);
                        $("#submit-btn").css("cursor", "pointer");
                    }

                }
            });
        }
        
    });


});
