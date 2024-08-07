(() => {
  // resources/js/job-listing.js
  jQuery(document).ready(function($) {
    var filterData = {
      full_or_part_time: "",
      location: "",
      min_salary: "",
      max_salary: ""
    };
    var salarySlider = document.getElementById("salary_slider");
    if (salarySlider) {
      noUiSlider.create(salarySlider, {
        start: [2e4, 5e4],
        connect: true,
        range: {
          min: 0,
          max: 1e5
        },
        step: 5e3,
        tooltips: true,
        format: {
          to: function(value) {
            return Math.round(value);
          },
          from: function(value) {
            return Number(value);
          }
        }
      });
      salarySlider.noUiSlider.on("update", function(values) {
        $("#min_salary").val(values[0]);
        $("#max_salary").val(values[1]);
        $("#salary_value").text("\xA3" + Math.round(values[0]) + " - \xA3" + Math.round(values[1]));
      });
    }
    $("#job-filter-form").on("change", function(event) {
      event.preventDefault();
      filterData.full_or_part_time = $("#full_or_part_time").val();
      filterData.location = $("#location").val();
      filterData.min_salary = $("#min_salary").val();
      filterData.max_salary = $("#max_salary").val();
      filterJobs(1);
    });
    $("#reset-filters").on("click", function() {
      filterData = {
        full_or_part_time: "",
        location: "",
        min_salary: "",
        max_salary: ""
      };
      filterJobs(1);
    });
    function performSearch(searchQuery, searchType, page2, status) {
      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: "POST",
        data: {
          action: "search_jobs",
          s: searchQuery,
          search_type: searchType,
          paged: page2,
          status
        },
        success: function(response) {
          console.log("Search response:", response);
          if (response.success) {
            if (page2 === 1) {
              $("#job-listing-container").html(response.data.posts);
              $("#my-job-listing-container").html(response.data.posts);
            } else {
              $("#job-listing-container").append(response.data.posts);
              $("#my-job-listing-container").append(response.data.posts);
            }
            $("#load-more-jobs").data("page", page2);
            if (page2 >= response.data.max_pages || response.data.posts_returned < 10) {
              $("#load-more-jobs").hide();
              $("#load-more-my-jobs").hide();
            } else {
              $("#load-more-jobs").show();
              $("#load-more-my-jobs").show();
            }
          } else {
            if (page2 === 1) {
              $("#job-listing-container").html("<p>No jobs found.</p>");
              $("#my-job-listing-container").html("<p>No jobs found.</p>");
            }
            $("#load-more-jobs").hide();
            $("#load-more-my-jobs").hide();
          }
        },
        error: function(errorThrown) {
          console.log("Search error:", errorThrown);
        }
      });
    }
    let page = 1;
    let timeout = null;
    $("#search-input").on("input", function(e) {
      e.preventDefault();
      const searchQuery = $(this).val();
      const searchType = $(this).siblings('input[name="search_type"]').val();
      const status = $(".title.active").data("status");
      clearTimeout(timeout);
      timeout = setTimeout(function() {
        performSearch(searchQuery, searchType, page, status);
      }, 500);
    });
    $("#load-more-jobs").on("click", function() {
      var page2 = $(this).data("page") || 1;
      filterJobs(page2 + 1);
    });
    function filterJobs(page2) {
      console.log("Requesting page:", page2);
      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: "POST",
        data: {
          action: "filter_jobs",
          full_or_part_time: filterData.full_or_part_time,
          location: filterData.location,
          min_salary: filterData.min_salary,
          max_salary: filterData.max_salary,
          paged: page2
        },
        beforeSend: function() {
          $("#loading").show();
        },
        success: function(response) {
          console.log("Filter response:", response);
          if (response.success) {
            if (page2 === 1) {
              $("#job-listing-container").html(response.data.posts);
            } else {
              $("#job-listing-container").append(response.data.posts);
            }
            $("#load-more-jobs").data("page", page2);
            if (page2 >= response.data.max_pages || response.data.posts_returned < 10) {
              $("#load-more-jobs").hide();
            } else {
              $("#load-more-jobs").show();
            }
          } else {
            if (page2 === 1) {
              $("#job-listing-container").html("<p>No jobs found.</p>");
            }
            $("#load-more-jobs").hide();
          }
          $("#loading").hide();
        },
        error: function(errorThrown) {
          console.log("Filter error:", errorThrown);
          $("#loading").hide();
        }
      });
    }
    const tabs = document.querySelectorAll(".title");
    tabs.forEach((tab) => {
      tab.addEventListener("click", function() {
        const status = this.getAttribute("data-status");
        const page2 = 1;
        tabs.forEach((tab2) => {
          tab2.classList.remove("active");
        });
        this.classList.add("active");
        filterMyJobs(status, page2);
      });
    });
    function filterMyJobs(status, page2) {
      console.log("Requesting page:", page2);
      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: "POST",
        data: {
          action: "categorise_jobs",
          status,
          paged: page2
        },
        beforeSend: function() {
          $("#loading").show();
        },
        success: function(response) {
          console.log("Filter response:", response);
          if (response.success) {
            if (page2 === 1) {
              $("#my-job-listing-container").html(response.data.posts);
            } else {
              $("#my-job-listing-container").append(response.data.posts);
            }
            var newPage = page2;
            $("#load-more-my-jobs").data("page", newPage);
            $("#load-more-my-jobs").data("status", status);
            if (page2 >= response.data.max_pages || response.data.total_posts < 10) {
              $("#load-more-my-jobs").hide();
            } else {
              $("#load-more-my-jobs").show();
            }
          } else {
            if (page2 === 1) {
              $("#my-job-listing-container").html("<p>No jobs found.</p>");
            }
            $("#load-more-my-jobs").hide();
          }
          $("#loading").hide();
        },
        error: function(errorThrown) {
          console.log("Filter error:", errorThrown);
          $("#loading").hide();
        }
      });
    }
    $("#load-more-my-jobs").on("click", function() {
      var page2 = $(this).data("page") || 1;
      filterMyJobs($(this).data("status"), page2 + 1);
    });
  });

  // resources/js/update-profile.js
  jQuery(document).ready(function($) {
    $(".edit-button").on("click", function() {
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
    $("#profile-update-form").on("submit", function(e) {
      e.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        url: "/wp-admin/admin-ajax.php",
        type: "POST",
        data: {
          action: "update_profile",
          data: formData,
          custom_profile_nonce: $("#custom_profile_nonce").val()
        },
        success: function(response) {
          if (response.success) {
            $(".first-name").text(response.data.first_name);
            $(".last-name").text(response.data.last_name);
            $(".email-display").text(response.data.email);
            $("#profile-update-success").text("Profile updated successfully!").show();
          } else {
            alert("Failed to update profile: " + response.data.message);
          }
        },
        error: function(errorThrown) {
          console.log(errorThrown);
          alert("An error occurred. Please try again.");
        }
      });
    });
  });

  // resources/js/app.js
  (() => {
    window.addEventListener("load", function() {
      let mobileNavigation = document.querySelector("#mobile");
      let mobileMenuToggle = document.querySelector("#mobile-menu-toggle");
      mobileMenuToggle.addEventListener("click", function(e) {
        e.preventDefault();
        console.log("clicked");
        mobileNavigation.classList.toggle("hidden");
      });
    });
  })();
  document.addEventListener("DOMContentLoaded", function() {
    const currentUrl = window.location.pathname;
    const menuItems = document.querySelectorAll("#menu-secondary-menu > li");
    menuItems.forEach((menuItem) => {
      const anchor = menuItem.querySelector("a");
      if (anchor && currentUrl.startsWith(new URL(anchor.href).pathname)) {
        menuItem.classList.add("menu-item-active");
        const bgColor = window.getComputedStyle(menuItem).backgroundColor;
        const subMenuItems = menuItem.querySelectorAll(".sub-menu li");
        subMenuItems.forEach((subMenuItem) => {
          subMenuItem.style.backgroundColor = bgColor;
        });
      }
    });
  });
  document.addEventListener("DOMContentLoaded", function() {
    var searchForm = document.getElementById("search-form");
    if (searchForm) {
      searchForm.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
          event.preventDefault();
        }
      });
    }
  });
  document.addEventListener("DOMContentLoaded", function() {
    const logoutMenuItem = document.querySelector(".logout-menu-item");
    if (logoutMenuItem) {
      logoutMenuItem.addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = logoutUrl;
      });
    }
  });
})();
