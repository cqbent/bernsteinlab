@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @php (print get_the_post_thumbnail( get_the_ID(), 'full' ))
    @include('partials.content-page')
  @endwhile
@endsection
