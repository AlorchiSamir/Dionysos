@extends('layouts.app')

@section('content')

<div class="container project-page">
	<h1>Mes Projets</h1>
	<a href="{{ url('project/create') }}" class='btn btn-success'>Ajouter un projet</a>
	<ul class='projects'>
		@if(!is_null($projects))
			@foreach($projects as $project)
				<li class='project strip'>
					<div>{{ $project->name }}</div>
					<hr>
					<a href="{{ url('project/create') }}" class='btn btn-primary'>Modifier</a>
				</li>
			@endforeach
		@endif
	</ul>
</div>

@endsection