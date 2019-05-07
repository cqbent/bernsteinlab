<article @php post_class() @endphp>
  <header>
    <h1 class="entry-title">{{ get_the_title() }}</h1>
  </header>
  <div class="entry-content">
    @php the_post_thumbnail('full') @endphp
    @php the_content() @endphp
    @if (get_field('people'))
      <h4>People</h4>
      @php print bernstein_research_people(get_field('people')) @endphp
    @endif
    @if (get_field('research_publications'))
      <h4>Publications</h4>
      Want to know more about this aspect of the lab? We recommend starting with the papers below
      @php print bernstein_research_publications(get_field('research_publications')) @endphp
    @endif
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
</article>
