jQuery(document).ready(function ($) {
  var filterData = {
    full_or_part_time: "",
    location: "",
    salary: "",
    published: "",
    sector: "",
    shift_type: "",
  };

  //Handle filter form submission
  $(
    "#job-filter-form, #mobile-job-filter-form, #when_published, #when_published_mobile"
  ).on("change", function (event) {
    event.preventDefault();

    filterData.full_or_part_time = $("#full_or_part_time").val();
    filterData.location = $("#location").val();
    filterData.salary = $("#salary").val();
    filterData.sector = $("#sector").val();
    filterData.shift_type = $("#shift_type").val();

    filterData.published = $("#when_published").val();

    // Mobile form values
    filterData.published =
      $("#when_published_mobile").val() || filterData.published; // Prioritize mobile value if available

    console.log("Calling filter jobs - change");

    filterJobs(1); // Reset to page 1 when filtering
  });

  //reset filters on button click
  $("#filter-reset").on("click", function () {
    filterData = {
      full_or_part_time: "",
      location: "",
      salary: "",
      published: "",
      sector: "",
      shift_type: "",
      sortOrder: "newest_first",
    };

    $("#job-filter-form")[0].reset();

    // Optionally reset the published filter if it's outside the form
    $("#when_published").val("");

    console.log("Calling filter jobs - reset");

    // Reset mobile form
    $("#mobile-job-filter-form")[0].reset();
    $("#when_published_mobile").val("");

    filterJobs(1);
  });

  // Define the page variable
  let page = 1;
  let postCount = $("#posts-count").text();

  // Prevent form submission on Enter key press

  $("#search-input").keydown(function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
    }
  });

  // Handle search form submission

  // Search input handling
  let timeout = null;
  $("#search-input").on("input", function (e) {
    e.preventDefault();
    const searchQuery = $(this).val();

    clearTimeout(timeout);

    timeout = setTimeout(function () {
      filterJobs(1, searchQuery);
    }, 500);
  });

  // Load more jobs on button click
  $("#load-more-jobs").on("click", function () {
    var page = $(this).data("page") || 1;
    console.log("Calling filter jobs - pagination");
    filterJobs(page + 1);
  });

  function filterJobs(page, searchQuery = "") {
    if (searchQuery === "") {
      searchQuery = $("#search-input").val();
    }

    console.log("Requesting page:", page); // Debugging line
    console.log("Search query:", searchQuery); // Debugging line
    $.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        action: "filter_jobs",
        page_id: $("#page-wrapper").data("page-id"),
        full_or_part_time: filterData.full_or_part_time,
        location: filterData.location,
        // min_salary: filterData.min_salary,
        // max_salary: filterData.max_salary,
        salary: filterData.salary,
        published: filterData.published,
        sector: filterData.sector,
        shift_type: filterData.shift_type,
        paged: page,
        search_query: searchQuery,
        sort_order: filterData.sortOrder || "newest_first",
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

          // Update the displayed post count

          postCount = $(".job-post").length;

          $("#posts-count").text(postCount);
          console.log(
            "Posts returned:",
            parseInt(postCount) + parseInt(response.data.posts_returned)
          );

          $("#load-more-jobs").data("page", page);

          if (
            page >= response.data.max_pages ||
            response.data.posts_returned < 10
          ) {
            console.log("hi");
            $("#posts-count-block").show();
            $("#posts-count").text(response.data.total_posts);

            $("#load-more-jobs").hide();
          } else {
            $("#load-more-jobs").show();
          }
        } else {
          if (page === 1) {
            $("#job-listing-container").html("<p>No jobs found.</p>");
            $("#posts-count").text(0);
            // Update the displayed post count
            // $("#posts-count-block").hide();
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

  //toggle info

  const moreLink = $("#morelink");
  const lessLink = $("#lesslink");

  if (moreLink.length) {
    moreLink.on("click", function (e) {
      e.preventDefault();
      $("#infosection").css("display", "flex");
      $(".openinfo").css("display", "none");
      //remove a class from main content
      $("#main-content").removeClass("lg:h-[220px]");
    });
  }

  if (lessLink.length) {
    lessLink.on("click", function (e) {
      e.preventDefault();
      $("#main-content").css("display", "flex");
      $("#infosection").css("display", "none");
      $(".openinfo").css("display", "flex");
      $("#main-content").addClass("lg:h-[220px]");
    });
  }

  //hide ad popup

  const adblock = $("#adblock");
  const closeAd = $("#adclose");

  if (adblock.length) {
    closeAd.on("click", function (e) {
      e.preventDefault();
      adblock.css("display", "none");
    });
  }
});
