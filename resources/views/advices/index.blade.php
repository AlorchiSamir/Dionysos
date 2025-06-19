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
	<div id='zone-advices'>
		<h2>{{ __('my').' '.__('advice') }}</h2>
		<div id='zone-list'>
			@include('advices.list2')
		</div>
	</div>
</div>

@endsection