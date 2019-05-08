<article @php post_class() @endphp>
  <header>
    <h1 class="entry-title">{{ get_the_title() }}</h1>
  </header>
  <div class="entry-content">
    @php the_content() @endphp
	  @php $images = get_field('image_gallery'); @endphp

	  @if ($images)
        @php $count = 0 @endphp
        <div class="image-gallery row">
          @foreach ($images as $image)
            @php $count++ @endphp
            <div class="col-md-4">
              <a href="#" data-toggle="modal" data-target="#image{{ $count }}">
                <img src="{{ $image['sizes']['medium'] }}" alt="{{ $image['alt'] }}" />
              </a>
              <p>{{ $image['caption'] }}</p>
              <div class="modal fade" id="image{{ $count }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <img src="{{ $image['sizes']['large'] }}"  />
                    </div>
                    <div class="col-md-12 description">
                      <p>{{ $image['caption'] }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
	  @endif

  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
</article>
