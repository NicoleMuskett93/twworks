// resources/js/app.js
import "./filter.js";
import "./pagination.js";
import "./slider.js";
import "./carousel.js";

(() => {
  // Wait for the window to load before executing JavaScript
  window.addEventListener("load", function () {
    // Select the mobile menu and toggle button
    let mobileNavigation = document.querySelector("#mobile");
    let mobileMenuToggle = document.querySelector("#mobile-menu-toggle");

    // Add click event listener to toggle button
    mobileMenuToggle.addEventListener("click", function (e) {
      e.preventDefault();
      console.log("clicked");
      mobileNavigation.classList.toggle("hidden");
    });
  });
})();

//Submenu display

document.addEventListener("DOMContentLoaded", function () {
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
