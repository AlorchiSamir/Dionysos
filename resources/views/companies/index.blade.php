@extends('layouts.app')

@section('content')

<div class='banner'>
	<div class='container'>
	    <ol class="breadcrumb-nav">
	        <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
	        <li class="breadcrumb-item active">{{ __('companies') }}</li>
	    </ol>
	    @include('search.form')
	</div>
</div>
<div class="container">
	@include('companies.options')	
    <section id='zone-professionals'>
    	<div id='results'>
	        <h2>{{ __('metiers') }}</h2>
	        <div id='zone-list'>
	            @include('companies.list')
	            {{ $companies->links() }}
	        </div>
    	</div>
    </section>
</div>

@endsection