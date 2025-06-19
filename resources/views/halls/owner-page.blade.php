@extends('layouts.app')

@section('content')

<div class="container owner-page">
	<h1>{{ __('my_halls') }}</h1>
	<a href="{{ url('hall/create') }}" class='btn btn-success'>{{ __('add_hall') }}</a>
	<ul class='halls'>
		@foreach($halls as $hall)
			<li class='hall strip'>
				<div>{{ $hall->name }}</div>
				<hr>
				<a href="{{ url('hall/settings/'.$hall->id.'/'.$hall->slug) }}" class='btn btn-primary'>{{ __('update') }}</a>
			</li>
		@endforeach
	</ul>
</div>

@endsection