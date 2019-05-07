<article @php post_class() @endphp>
  <div class="entry-content">
    <div class="entry-header row">
      <div class="col-md-3">
        @php the_post_thumbnail('full') @endphp
      </div>
      <div class="col-md-5">
        <div class="job-title">{!! get_field( 'job_title' ) !!}</div>
        <h4 class="title">{{ get_the_title() }}</h4>
        @if(get_field('email'))
          <div class="email">
            <a href="mailto:{{ get_field('email') }}">{{ get_field('email') }}</a>
          </div>
        @endif
      </div>
    </div>

    <div class="entry-body">
      @php the_content() @endphp
    </div>

  </div>
</article>
