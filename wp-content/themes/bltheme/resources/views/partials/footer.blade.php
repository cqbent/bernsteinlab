<footer class="content-info">
  @php(dynamic_sidebar('sidebar-footer'))
  <div class="site-info">
    <div class="container">
      <div class="row">
        <div class="logo col-md-3">
          <a href="/">
            <img src="<?php print get_stylesheet_directory_uri(); ?>/assets/images/bl_logo_footer.svg" alt="Bernstein Laboratory" />
          </a>
        </div>
        <div class="contact col-md-3">
          <p>
            <strong>Simches</strong><br />
            185 Cambridge Street<br />
            Boston, MA 02114<br />
            8th floor<br />
            Room 8400<br />
            Harvard or MGH badge required
          </p>
          <p>
            <strong>Broad Institute</strong><br />
            NE30<br />
            Cambridge, MA 02142
          </p>
        </div>
        <div class="footer-nav col-md-3">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary_navigation',
					'container_class' => 'sidebar-navigation',
					'menu_class' => 'menu-footer-menu',
					'depth' => 1
				)
			);
			?>
        </div>
        <div class="copyright col-md-3">
          Copyright © 2018<br />
          <strong>Bernstein Laboratory</strong><br />
          All Rights Reserved.
        </div>

      </div>
    </div>
  </div>
</footer>
