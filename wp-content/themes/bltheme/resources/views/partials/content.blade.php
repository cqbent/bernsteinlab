<article @php post_class() @endphp>
  <header>
    <h2 class="entry-title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h2>
    @include('partials/entry-meta')
  </header>
  <div class="entry-summary">
    @php print wp_trim_excerpt() @endphp
  </div>
</article>
