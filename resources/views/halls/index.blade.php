@extends('layouts.app')

@section('content')

<div class='banner'>
	<div class='container'>
	    <ol class="breadcrumb-nav">
	        <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
	        <li class="breadcrumb-item active">{{ __('halls') }}</li>
	    </ol>
	    @include('search.form')
	</div>
</div>
<div class="container">
	@include('halls.list')
	{{ $halls->links() }}
</div>

@endsection