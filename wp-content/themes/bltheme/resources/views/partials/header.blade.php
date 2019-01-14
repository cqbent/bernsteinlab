<header class="banner">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}">
      <img src="{{ get_stylesheet_directory_uri() }}/assets/images/bl_logo.svg" alt="Bernstein Labs" />
    </a>
    <nav class="nav-primary">
      @if (has_nav_menu('primary_navigation'))
        <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container_id' => 'navbar', 'container_class' => 'menu-primary collapse fade']) !!}
      @endif
    </nav>
    <?php print get_search_form(); ?>
  </div>
</header>
