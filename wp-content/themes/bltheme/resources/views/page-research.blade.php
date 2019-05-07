@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  @include('partials.page-header')
  @php (print get_the_post_thumbnail( get_the_ID(), 'full' ))
  <div class="page-content">
    <div class="feature-box row">
      <div class="feature-text">
	      <?php
	      the_content();
	      ?>
      </div>
    </div>
    @php (print do_shortcode('[research_list]'))
  </div>
  <div class="research-content">

  </div>
  @endwhile
@endsection
