@extends('layouts.app')

@section('content')
<div class='home'>
	<div class='banner' style="background-image:url({{url('graphics/disco2.jpg')}})">
		<div class='container'>
		    @include('search.form')
		</div>
	</div>
	<div class="container">
		<div class='center margin'>
			<h2>{{ __('welcome') }}</h2>
			<p>Organiser votre soirée de rêve.</p>
			<p>Trouver une salle, un deejay ou une entreprise de nettoyage. Compléter ce qui manque pour l'organisation de votre soirée.</p>
			<p>Utilisez notre module de projets afin d'avoir une vue sur l'évolution de l'organisation de votre soirée.</p>
		</div>
		<hr>
		<div class='zone-videos'>
			<h2>{{ __('last_videos') }}</h2>
			<p><a href="{{ url('/studio') }}">Studio</a></p>
			@foreach($videos as $video)
			<div class='video'>
				<div class='professional'>

					<span><a href="{{ url('professional/'.$video->professional->id.'/'.$video->professional->slug) }}">
					 <img class='avatar-round' src="{{  url('images/avatar/crop/'.$video->professional->getSetting('avatar')) }}" />{{ $video->professional->surname }}
					</a></span>
				</div>
				<iframe width="360" height="280" src="https://www.youtube.com/embed/{{ $video->url }}">
          		</iframe>
          	</div>
			@endforeach
		</div>
		<hr>
	</div>
</div>
@endsection