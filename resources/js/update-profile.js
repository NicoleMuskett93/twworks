jQuery(document).ready(function ($) {
    $(".edit-button").on("click", function () {
        var field = $(this).data("field");
        var displayElement = $("#" + field + "_display");
        var inputElement = $("#" + field + "_input");
        var button = $(this);
        var submitButton = $("#profile-update-button");

        if (button.text().trim() === "Edit") {
            displayElement.hide();
            inputElement.show().focus();
            button.text("Save");
        } else {
            displayElement.find("span").text(inputElement.val());
            displayElement.show();
            inputElement.hide();
            button.text("Edit");
        }
    });

    $("#profile-update-form").on("submit", function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: "/wp-admin/admin-ajax.php",
            type: "POST",
            data: {
                action: 'update_profile',
                data: formData,
                custom_profile_nonce: $("#custom_profile_nonce").val()
            },
            success: function (response) {
                if (response.success) {

                    $(".first-name").text(response.data.first_name);
                    $(".last-name").text(response.data.last_name);
                    $(".email-display").text(response.data.email);



                    $("#profile-update-success")
                        .text("Profile updated successfully!")
                        .show()

                       
                    
                } else {
                    alert("Failed to update profile: " + response.data.message);
                }
            },
            error: function (errorThrown) {
                console.log(errorThrown);
                alert("An error occurred. Please try again.");
            }
        });
    });
});
