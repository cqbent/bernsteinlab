@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <div class="home-banner">
      @php (print get_the_post_thumbnail( get_the_ID(), 'full' ))
      <div class="tagline">
        Epigenomic Regulation in Development and Cancer
      </div>
    </div>
    <div class="home-content">
      <div class="info row justify-content-center">
        <div class="column what-we-do col-sm-5">
          <h4>What We Do</h4>
          <p>
            Bernstein lab pursues a systems-level, molecular understanding of chromatin structure and
            the epigenetic regulation of cellular state, and how these systems go awry in disease.</p>
          <a href="/research" class="btn btn-primary">More</a>
        </div>
        <div class="column locations col-sm-7">
          <h4>Locations</h4>
          <div class="row">
            <div class="column col-sm-6">
                <img src="@php (print get_stylesheet_directory_uri())/assets/images/hms_mgh_logo.png" />
                <p><strong>MGH Research lab</strong><br />
                185 Cambridge Street <br />
                  Boston, MA</p>
              <a href="/research" class="btn btn-primary">More</a>
            </div>
            <div class="column col-sm-6">
              <img src="@php (print get_stylesheet_directory_uri())/assets/images/broad_epigenomics_logo.png" />
              <p><strong>Broad Institute</strong><br />
              415 Main Street, Room 6041<br />
              Cambridge, MA</p>
              <a href="/broad-institute-epigenomics-program" class="btn btn-primary">More</a>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="latest-news">
      <?php print bernstein_latest_news(); ?>
    </div>
    <div class="research container">
      <h3>Research Areas</h3>
      <?php print do_shortcode('[research_list]'); ?>
    </div>
  @endwhile
@endsection
