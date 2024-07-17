
<?php
/* Custom search form */
?>
<form role="search" method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="input-group mb-3">
  <div class="input-group">
    <input class="w-full max-w-96 relative px-3 py-2 rounded" type="search" class="form-control border-0" placeholder="Search" aria-label="search nico" name="s" id="search-input" value="<?php echo esc_attr( get_search_query() ); ?>">
    <button class="absolute z-10" type="submit" id="search-submit">
      <i class="fas fa-search text-lg text-black"></i>
    </button>

  </div>
</form>
 