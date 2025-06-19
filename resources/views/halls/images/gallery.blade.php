@extends('layouts.app')

@section('content')

<div class='banner'>
	<div class='container'>
	    <ol class="breadcrumb-nav">
	        <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
	        <li class="breadcrumb-item"><a href="{{ url('/professional') }}">{{ __('halls') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/hall/'.$hall->id.'/'.$hall->slug) }}">{{ $hall->name }}</a></li>
            <li class="breadcrumb-item active">{{ __('gallery') }}</li>
	    </ol>
	    @include('search.form')
	</div>
</div>
<div class="container gallery">
	<a href="{{ url('/hall/'.$hall->id.'/'.$hall->slug) }}">{{ __('return') }}</a>
	<div class='images'>
        <h3>Galerie <span>({{ count($hall->images) }})</span></h3>
        <ul>
        @foreach($hall->images as $image)
        <li>
            <a href="{{  url('images/hall/'.$image->url) }}" data-lightbox="{{ $image->id }}">
            	<img src="{{  url('images/hall/'.$image->url) }}" class='miniature' >
            </a>
        </li>
        @endforeach
      </ul>
      
      </div>
</div>



<script>
	

$(function() {

	/* This is basic - uses default settings */
	
	

	
	
	
});

</script>

@endsection