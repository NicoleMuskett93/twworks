
<form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative mb-5">
  <div class="relative">
  <input type="hidden" name="search_type" value="<?php echo is_page('my-jobs') ? 'my' : 'all'; ?>">
    <input id="search-input" class="w-full max-w-96 pl-10 py-2 rounded" type="search" placeholder="Search for jobs" name="s">
      <div class="absolute top-1/2 left-3 transform -translate-y-1/2 bg-transparent border-none z-10" type="submit" id="search-submit">
        <i class="fas fa-search text-lg text-black"></i>
      </div>
  </div>
</form>


