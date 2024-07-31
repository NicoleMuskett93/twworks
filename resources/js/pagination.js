jQuery(document).ready(function ($) {
  $("#load-more-jobs").on("click", function () {
    var page = $(this).data("page") || 1; // Get the current page number
    var button = $(this);
    var max_pages = $(this).data("max-pages"); // Get the maximum number of pages

    $.ajax({
      url: "/wp-admin/admin-ajax.php", // WordPress's global ajaxurl variable
      type: "POST",
      data: {
        action: "load_more_jobs",
        page: page,
      },

      beforeSend: function () {
        button.text("Loading..."); // Change the button text
        $("#loading").show(); // Show the loading div
      },
      success: function (response) {
        if (response.success) {
          var newPosts = $(response.data.posts).filter(".job-post").length;

          // Append new posts to the job listing container
          $("#job-listing-container").append(response.data.posts);

          // Update the page number for the next load
          var nextPage = page + 1;
          button.data("page", nextPage);
          button.text("Load More Jobs");

          // Hide the button if fewer than 5 posts were returned or if the next page exceeds max pages
          if (
            response.data.posts_returned < 5 ||
            nextPage > response.data.max_pages
          ) {
            button.hide();
            console.log(
              "Fewer than 5 posts returned or no more pages available, hiding button"
            );
          }
        } else {
          button.hide(); // Hide the button if no response
          console.log("No more posts");
        }

        $("#loading").hide(); // Hide the loading div
      },
      error: function (errorThrown) {
        console.log(errorThrown); // Log errors for debugging
        button.text("Load More Jobs"); // Reset button text on error
        $("#loading").hide(); // Hide the loading div
      },
    });
  });
});
