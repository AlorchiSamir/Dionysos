@extends('layouts.app')

@section('content')
<div class='banner'>
	<div class='container'>	    
	    @include('search.form')
	</div>
</div>
<div class="container">
	<div>{{ __('no_result') }}</div>
</div>
@endsection