<form role="search" method="get" id="search-form" action="<?php echo esc_url(home_url()); ?>" class="relative rounded">
  <div class="relative">
    <input type="hidden" name="search_type" value="<?php echo is_page('my-jobs') ? 'my' : 'all'; ?>">
    <input id="search-input" class="w-full border border-grey lg:max-w-96 pl-10 py-3 rounded-sm text-base" type="search" placeholder="Search" name="s">
    <button class="absolute top-1/2 left-3 transform -translate-y-1/2 bg-transparent border-none z-10" type="submit" id="search-submit">
      <i class="fas fa-search text-lg text-darkergreen"></i>
</button>
  </div>
</form>