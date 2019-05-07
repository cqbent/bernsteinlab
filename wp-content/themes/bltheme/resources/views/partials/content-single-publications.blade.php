<article @php post_class() @endphp>
  <header>
    <h1 class="entry-title">{{ get_the_title() }}</h1>
    @include('partials/entry-meta')
    @if(get_field('pubmed_id'))
      <div class="journal">{{ get_field('journal_name') }}</div>
      <div class="pubmed">
        <a href="https://www.ncbi.nlm.nih.gov/pubmed/{{ get_field('pubmed_id') }}" target="_blank">PubMed Link</a>
      </div>
    @endif
  </header>
  <div class="entry-content">
    @php the_post_thumbnail('full') @endphp
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
</article>
