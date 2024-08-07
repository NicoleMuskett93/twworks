// jQuery(document).ready(function ($) {
//   //Initialize noUiSlider for salary range
//   var salarySlider = document.getElementById("salary_slider");
//   if (salarySlider) {
//     noUiSlider.create(salarySlider, {
//       start: [20000, 50000],
//       connect: true,
//       range: {
//         min: 0,
//         max: 100000,
//       },
//       step: 5000,
//       tooltips: true,
//       format: {
//         to: function (value) {
//           return Math.round(value);
//         },
//         from: function (value) {
//           return Number(value);
//         },
//       },
//     });

//     // Update hidden inputs with slider values
//     salarySlider.noUiSlider.on("update", function (values) {
//       $("#min_salary").val(values[0]);
//       $("#max_salary").val(values[1]);
//       $("#salary_value").text(
//         "£" + Math.round(values[0]) + " - £" + Math.round(values[1])
//       );
//     });
//   }

//   /**
//    * Run AJAX function when user stops typing
//    */

//   let timeout = null;

//   // Attach input event listener to the search input field
//   $("#search-input").on("input", function (e) {
//     e.preventDefault();
//     const searchQuery = $(this).val();
//     // Clear the previous timeout
//     clearTimeout(timeout);

//     // Set a new timeout to run the AJAX function after 500 milliseconds
//     timeout = setTimeout(function () {
//       // AJAX request to fetch search results
//       $.ajax({
//         url: "/wp-admin/admin-ajax.php", // Use WordPress's global ajaxurl variable
//         type: "POST",
//         data: {
//           action: "search_jobs",
//           s: searchQuery, // Include search query in AJAX data
//         },
//         success: function (response) {
//           $("#job-listing-container").html(response); // Update container with the search results
//         },
//         error: function (errorThrown) {
//           console.log(errorThrown); // Log errors for debugging
//         },
//       });
//     }, 500); // Delay in milliseconds
//   });

//   // Handle filter form submission
//   $("#job-filter-form").on("submit", function (event) {
//     event.preventDefault();

//     var full_or_part_time = $("#full_or_part_time").val(); // Get filter values
//     var location = $("#location").val();
//     var min_salary = $("#min_salary").val();
//     var max_salary = $("#max_salary").val();

//     $.ajax({
//       url: "/wp-admin/admin-ajax.php", // Use WordPress's global ajaxurl variable
//       type: "POST",
//       data: {
//         action: "filter_jobs",
//         full_or_part_time: full_or_part_time,
//         location: location,
//         min_salary: min_salary,
//         max_salary: max_salary,
//       },
//       success: function (response) {
//         $("#job-listing-container").html(response); // Update container with the filtered results
//       },
//       error: function (errorThrown) {
//         console.log(errorThrown); // Log any errors to console
//       },
//     });
//   });
// });
