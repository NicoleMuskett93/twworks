// resources/js/app.js
import "./filter.js";
import "./pagination.js";
import "./slider.js";
import "./carousel.js";
import "./job-listing.js";
import "./update-profile.js";
import "./datepicker.js";

(() => {
  // Wait for the window to load before executing JavaScript
  window.addEventListener("load", function () {
    // Select the mobile menu and toggle button
    let mobileNavigation = document.querySelector("#mobile");
    let mobileMenuToggle = document.querySelector("#mobile-menu-toggle");
    let burgerIcon = document.querySelector("#burger");
    let closeIcon = document.querySelector("#close");

    // Add click event listener to toggle button
    mobileMenuToggle.addEventListener("click", function (e) {
      e.preventDefault();
      console.log("clicked");

      // Toggle mobile menu visibility
      mobileNavigation.classList.toggle("hidden");

      // Toggle visibility of burger and close icons
      if (mobileNavigation.classList.contains("hidden")) {
        burgerIcon.style.display = "flex";
        closeIcon.style.display = "none";
      } else {
        burgerIcon.style.display = "none";
        closeIcon.style.display = "flex";
      }
    });
  });
})();

//mobile submenu display

document.addEventListener("DOMContentLoaded", function () {
  const dropdowns = document.querySelectorAll(".dropdown > a");

  dropdowns.forEach((dropdown) => {
    dropdown.addEventListener("click", function (event) {
      event.preventDefault();

      // Toggle the sub-menu display
      const subMenu = dropdown.nextElementSibling;
      if (subMenu && subMenu.classList.contains("sub-menu")) {
        subMenu.style.display =
          subMenu.style.display === "block" ? "none" : "block";

        // Toggle the chevron direction by adding/removing the 'open' class
        dropdown.classList.toggle("open");
      }
    });
  });
});

// filters appear on click for mobile

document.addEventListener("DOMContentLoaded", function () {
  const filterButton = document.querySelector("#searchandfilters");
  const filterForm = document.querySelector("#mobilefilters");

  if (filterButton && filterForm) {
    filterButton.addEventListener("click", function () {
      filterForm.classList.toggle("hidden");
      filterButton.classList.add("hidden");
    });
  }
});

// stop search submiting on enter

document.addEventListener("DOMContentLoaded", function () {
  var searchForm = document.getElementById("search-form");

  if (searchForm) {
    searchForm.addEventListener("keydown", function (event) {
      if (event.key === "Enter") {
        event.preventDefault();
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const logoutMenuItem = document.querySelector(".logout-menu-item");

  if (logoutMenuItem) {
    logoutMenuItem.addEventListener("click", function (event) {
      event.preventDefault(); // Prevent the default link behavior
      window.location.href = logoutUrl;
    });
  }
});

//add active class to anchor tag

document.addEventListener("DOMContentLoaded", function () {
  const currentUrl = window.location.pathname;
  const anchors = document.querySelectorAll(".activelinks > a");

  // On page load, check if the URL matches the anchor href and add 'active' class
  anchors.forEach((anchor) => {
    if (anchor && currentUrl.startsWith(new URL(anchor.href).pathname)) {
      anchor.classList.add("active");
    }

    // Add event listener for 'click' on each anchor to add 'active' class
    anchor.addEventListener("click", function () {
      // Remove 'active' class from all anchors
      anchors.forEach((link) => link.classList.remove("active"));

      // Add 'active' class to the clicked anchor
      this.classList.add("active");
    });
  });
});

//add placeholder to login form

document.addEventListener("DOMContentLoaded", function () {
  // Set the placeholder for the username field
  const usernameField = document.getElementById("user_login");
  if (usernameField) {
    usernameField.setAttribute("placeholder", "Username");
  }

  // Set the placeholder for the password field
  const passwordField = document.getElementById("user_pass");
  if (passwordField) {
    passwordField.setAttribute("placeholder", "Password");
  }
});

//hide submen on /my-jobs if login is present

document.addEventListener("DOMContentLoaded", function () {
  const currentUrl = window.location.pathname;
  const myjobsUrl = "/my-jobs";
  const myjobsUrlWithSlash = "/my-jobs/";
  const loginForm = document.getElementById("loginform");
  const subMenu = document.querySelector(
    "#secondary-menu #menu-secondary-menu li .sub-menu"
  );

  // Check if we're on the '/my-jobs' page (with or without trailing slash) and if the login form exists
  if (
    (currentUrl === myjobsUrl || currentUrl === myjobsUrlWithSlash) &&
    loginForm &&
    subMenu
  ) {
    subMenu.style.display = "none";
  }
});
// if salary entered = 0, display unspecified

// document.addEventListener("DOMContentLoaded", function () {
//   const salaryInput = document.querySelector("#job_salary");
//   const unspecified = document.querySelectorAll(".unspecified");

//   if (salaryInput && unspecified) {
//     if (salaryInput.value === "0") {
//       unspecified.forEach((element) => {
//         element.textContent = "Unspecified";
//       });
//     }
//   }
// });

//on click of checkbox, hide field and display text in place

document.addEventListener("DOMContentLoaded", function () {
  const checkbox = document.querySelector("#volunteering");
  const text = document.querySelector("#unspecified-text");
  const salary = document.querySelector("#job_salary");

  if (checkbox) {
    checkbox.addEventListener("click", function () {
      console.log("clicked");
      if (checkbox.checked) {
        salary.classList.add("voluntary");
        text.classList.add("hidden");
        salary.value = "0";
        salary.readOnly = true;
      } else {
        salary.classList.remove("voluntary");
      }
    });
  }
});
