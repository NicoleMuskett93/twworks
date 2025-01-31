jQuery(document).ready(function ($) {
  const dateInput = $("#job_start_date");
  const dateInputTwo = $("#job_publish_date");
  const dateInputThree = $("#job_expiry_date");
  const dateInputFour = $("#job_publish_date_edit");
  const today = new Date();
  const formattedDate = today.toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
  dateInput.attr("min", formattedDate);
  dateInputTwo.attr("min", formattedDate);
  dateInputThree.attr("min", formattedDate);
  dateInputFour.attr("min", formattedDate);
});
