@extends('layouts.app')

@section('content')
<div class='banner'>
	<div class='container'>
	    <ol class="breadcrumb-nav">
	        <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
	        <li class="breadcrumb-item active">{{ __('skills') }}</li>
	    </ol>
	    @include('search.form')
	</div>
</div>
<div class="container">	
	<div class="metiers-page">
		@include('metiers.skills.list')
	</div>
</div>
@endsection