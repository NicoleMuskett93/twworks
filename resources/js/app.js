// resources/js/app.js

(() => {
  // Wait for the window to load before executing JavaScript
  window.addEventListener("load", function () {
    // Select the primary menu and toggle button
    let mainNavigation = document.querySelector("#primary-menu");
    let primaryMenuToggle = document.querySelector("#primary-menu-toggle");

    // Add click event listener to toggle button
    primaryMenuToggle.addEventListener("click", function (e) {
      e.preventDefault();
      mainNavigation.classList.toggle("hidden");
    });
  });

  // // Wait for the DOM content to be loaded before executing further JavaScript
  // document.addEventListener("DOMContentLoaded", function () {
  //   // Select login link and body element
  //   let loginLink = document.querySelector(".loginmenuitem a");
  //   let subMenu = document.querySelector(".loginmenuitem ul");
  //   let body = document.body;

  //   // Function to change login link text if user is an employer
  //   function changeMenuItem() {
  //     if (
  //       body.classList.contains("role-employer") ||
  //       body.classList.contains("role-administrator")
  //     ) {
  //       loginLink.textContent = currentUser.displayName;
  //     }
  //   }
  //   console.log("hi");

  //   function hideSubMenu() {
  //     if (currentUser.roles.includes("administrator")) {
  //       subMenu.style.display = "none";
  //     }
  //   }

  //   changeMenuItem();
  //   hideSubMenu();
  // });
})();
