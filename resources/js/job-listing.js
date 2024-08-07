jQuery(document).ready(function ($) {
  var filterData = {
    full_or_part_time: "",
    location: "",
    min_salary: "",
    max_salary: "",
  };

  // Initialize noUiSlider for salary range
  var salarySlider = document.getElementById("salary_slider");
  if (salarySlider) {
    noUiSlider.create(salarySlider, {
      start: [20000, 50000],
      connect: true,
      range: {
        min: 0,
        max: 100000,
      },
      step: 5000,
      tooltips: true,
      format: {
        to: function (value) {
          return Math.round(value);
        },
        from: function (value) {
          return Number(value);
        },
      },
    });

    // Update hidden inputs with slider values
    salarySlider.noUiSlider.on("update", function (values) {
      $("#min_salary").val(values[0]);
      $("#max_salary").val(values[1]);
      $("#salary_value").text(
        "£" + Math.round(values[0]) + " - £" + Math.round(values[1])
      );
    });
  }

  // Handle filter form submission
  $("#job-filter-form").on("change", function (event) {
    event.preventDefault();

    filterData.full_or_part_time = $("#full_or_part_time").val();
    filterData.location = $("#location").val();
    filterData.min_salary = $("#min_salary").val();
    filterData.max_salary = $("#max_salary").val();

    filterJobs(1); // Reset to page 1 when filtering
  });

  //reset filters on button click
  $("#reset-filters").on("click", function () {
    filterData = {
      full_or_part_time: "",
      location: "",
      min_salary: "",
      max_salary: "",
    };

    filterJobs(1); // Reset to page 1 when filtering
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
        min_salary: filterData.min_salary,
        max_salary: filterData.max_salary,
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

      filterMyJobs(status, page);
    });
  });

  function filterMyJobs(status, page) {
    console.log("Requesting page:", page);
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
        console.log("Filter response:", response);
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
});
