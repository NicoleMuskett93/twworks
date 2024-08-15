jQuery(document).ready(function ($) {
  var filterData = {
    full_or_part_time: "",
    location: "",
    salary: "",
    published: "",
  };

  // Handle filter form submission
  $("#job-filter-form").on("change", function (event) {
    event.preventDefault();

    filterData.full_or_part_time = $("#full_or_part_time").val();
    filterData.location = $("#location").val();
    filterData.salary = $("#salary").val();
    filterData.published = $("#when_published").val();

    filterJobs(1); // Reset to page 1 when filtering
  });

  //reset filters on button click
  $("#filter-reset").on("click", function () {
    filterData = {
      full_or_part_time: "",
      location: "",
      salary: "",
      published: "",
    };

    $("#job-filter-form")[0].reset();

    filterJobs(1);
  });

  function performSearch(searchQuery, searchType, page, status) {
    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        action: "search_jobs",
        s: searchQuery,
        search_type: searchType, // Pass the search type
        paged: page,
        status: status,
      },
      success: function (response) {
        console.log("Search response:", response);
        if (response.success) {
          if (page === 1) {
            $("#job-listing-container").html(response.data.posts);
            $("#my-job-listing-container").html(response.data.posts);
          } else {
            $("#job-listing-container").append(response.data.posts);
            $("#my-job-listing-container").append(response.data.posts);
          }
          $("#load-more-jobs").data("page", page);

          if (
            page >= response.data.max_pages ||
            response.data.posts_returned < 10
          ) {
            $("#load-more-jobs").hide();
            $("#load-more-my-jobs").hide();
          } else {
            $("#load-more-jobs").show();
            $("#load-more-my-jobs").show();
          }
        } else {
          if (page === 1) {
            $("#job-listing-container").html("<p>No jobs found.</p>");
            $("#my-job-listing-container").html("<p>No jobs found.</p>");
          }
          $("#load-more-jobs").hide();
          $("#load-more-my-jobs").hide();
        }
      },
      error: function (errorThrown) {
        console.log("Search error:", errorThrown);
      },
    });
  }

  // Define the page variable
  let page = 1;

  // Search input handling
  let timeout = null;
  $("#search-input").on("input", function (e) {
    e.preventDefault();
    const searchQuery = $(this).val();
    const searchType = $(this).siblings('input[name="search_type"]').val(); // Determine search type
    const status = $(".title.active").data("status");

    clearTimeout(timeout);

    timeout = setTimeout(function () {
      performSearch(searchQuery, searchType, page, status);
    }, 500);
  });

  // Load more jobs on button click
  $("#load-more-jobs").on("click", function () {
    var page = $(this).data("page") || 1;
    filterJobs(page + 1);
  });

  function filterJobs(page) {
    console.log("Requesting page:", page); // Debugging line
    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        action: "filter_jobs",
        full_or_part_time: filterData.full_or_part_time,
        location: filterData.location,
        // min_salary: filterData.min_salary,
        // max_salary: filterData.max_salary,
        salary: filterData.salary,
        published: filterData.published,
        paged: page,
      },
      beforeSend: function () {
        $("#loading").show();
      },
      success: function (response) {
        console.log("Filter response:", response); // Debugging line
        if (response.success) {
          if (page === 1) {
            $("#job-listing-container").html(response.data.posts);
          } else {
            $("#job-listing-container").append(response.data.posts);
          }

          $("#load-more-jobs").data("page", page);

          if (
            page >= response.data.max_pages ||
            response.data.posts_returned < 10
          ) {
            $("#load-more-jobs").hide();
          } else {
            $("#load-more-jobs").show();
          }
        } else {
          if (page === 1) {
            $("#job-listing-container").html("<p>No jobs found.</p>");
          }
          $("#load-more-jobs").hide();
        }

        $("#loading").hide();
      },
      error: function (errorThrown) {
        console.log("Filter error:", errorThrown);
        $("#loading").hide();
      },
    });
  }

  // my-jobs category filter
  const tabs = document.querySelectorAll(".title");

  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      const status = this.getAttribute("data-status");
      const page = 1; // Start from the first page for filtering

      // Remove 'active' class from all tabs
      tabs.forEach((tab) => {
        tab.classList.remove("active");
      });

      // Add 'active' class to the clicked tab
      this.classList.add("active");

      filterMyJobs(status);
    });
  });

  function filterMyJobs(status, page = 1) {
    console.log("Requesting page:", page);
    console.log("Status:", status);
    console.log("Page:", page);
    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        action: "categorise_jobs",
        status: status,
        paged: page,
      },
      beforeSend: function () {
        $("#loading").show();
      },
      success: function (response) {
        console.log("Filter response:", response, status);
        if (response.success) {
          if (page === 1) {
            $("#my-job-listing-container").html(response.data.posts);
          } else {
            $("#my-job-listing-container").append(response.data.posts);
          }

          // Update the data-page attribute correctly
          var newPage = page;
          $("#load-more-my-jobs").data("page", newPage);
          $("#load-more-my-jobs").data("status", status); // Save the status too

          if (
            page >= response.data.max_pages ||
            response.data.total_posts < 10
          ) {
            $("#load-more-my-jobs").hide();
          } else {
            $("#load-more-my-jobs").show();
          }
        } else {
          if (page === 1) {
            $("#my-job-listing-container").html("<p>No jobs found.</p>");
          }
          $("#load-more-my-jobs").hide();
        }
        $("#loading").hide();
      },
      error: function (errorThrown) {
        console.log("Filter error:", errorThrown);
        $("#loading").hide();
      },
    });
  }

  // Load more jobs on button click for my-jobs
  $("#load-more-my-jobs").on("click", function () {
    var page = $(this).data("page") || 1; // Use default page 1 if undefined

    // Increment page before passing it to filterMyJobs
    filterMyJobs($(this).data("status"), page + 1);
  });

  // On selection of publish make sure date is today
  // $("#job_published").on("click", function () {
  //   console.log($("#job_published").val());
  //   const selectedDate = $("#job_publish_date").val();
  //   const todayDate = new Date().toISOString().split("T")[0];
  //   const futureField = $('#job_future');

  //   // Remove any existing error message
  //   $("#date-error-message").remove();

  //   if (selectedDate === !todayDate) {
  //     console.log("date matches");

  //   } else {
  //     //Display an inline error message
  //     $("#job_publish_date").after(
  //       '<span id="date-error-message" style="color: red;">Publish date must be set to today.</span>'
  //     );
  //     $("#job_publish_date").focus(); // Focus on the date field
  //   }
  // });
});
