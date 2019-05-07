@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <div class="home-banner">
      @php (print get_the_post_thumbnail( get_the_ID(), 'full' ))
      <div class="content">
        <div class="tagline">
          Epigenomic Regulation in Development and Cancer
        </div>
        <a href="/research" class="btn btn-primary">What We Do</a>
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
