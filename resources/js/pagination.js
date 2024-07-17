jQuery(document).ready(function($) {
    
    $('#your-filter-form').on('submit', function(event) {
        event.preventDefault();
        
        var full_or_part_time = $('#job_time').val(); // Adjust based on your form's setup
        
        $.ajax({
            url: ajaxurl, // WordPress AJAX URL
            type: 'POST',
            data: {
                action: 'filter_jobs',
                full_or_part_time: full_or_part_time
            },
            success: function(response) {
                // Handle success response (e.g., replace content with filtered posts)
                $('#job-listing-container').html(response);
            },
            error: function(errorThrown) {
                console.log(errorThrown); // Log any errors to console
            }
        });
    });
});
