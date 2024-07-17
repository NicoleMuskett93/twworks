(() => {
  // resources/js/app.js
  (() => {
    window.addEventListener("load", function() {
      let mainNavigation = document.querySelector("#primary-menu");
      let primaryMenuToggle = document.querySelector("#primary-menu-toggle");
      primaryMenuToggle.addEventListener("click", function(e) {
        e.preventDefault();
        mainNavigation.classList.toggle("hidden");
      });
    });
  })();
})();
