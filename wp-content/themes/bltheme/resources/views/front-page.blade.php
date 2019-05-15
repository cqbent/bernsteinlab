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
        <div class="column col-sm-6">
          <h4>What We Do</h4>
          <p>
            The Bernstein lab pursues a systems-level, molecular understanding of chromatin structure and
            the epigenetic regulation of cellular state, and how these control systems go awry in diseases
            like cancer.</p>
          <a href="/research" class="btn btn-primary">More</a>
        </div>
        <div class="column col-sm-6">
          <h4>Locations</h4>
          <p><strong>MGH, Simches Research Center</strong><br />
            185 Cambridge Street
            Boston, MA</p>
          <p><strong>Broad Institute</strong><br />
            415 Main Street, Room 6041
            Cambridge, MA</p>
          <a href="/locations" class="btn btn-primary">More</a>
        </div>
      </div>
    </div>
    <div class="latest-news">
      <?php print bernstein_latest_news(); ?>
    </div>
    <div class="research container">
      <?php print do_shortcode('[research_list cols="4"]'); ?>
    </div>
  @endwhile
@endsection
