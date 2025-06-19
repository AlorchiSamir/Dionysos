<h2>{{ __('persons') }} <span>{{ $metiers['person']['count'] }}</span></h2>
@foreach($metiers['person']['metiers'] as $metier)
	<div class='metier'>
		<h3 style="background-color: {{ $metier->color  }}"><a href="{{ url('metier/'.$metier->id.'/'.$metier->name) }}">{{ __($metier->name) }} <span>{{ $metier->getProfessionalCount() }}</span></a></h3>
		<ul>
		@foreach($metier->skills as $skill)
			<li class='skill'><a href="{{ url('skill/'.$skill->id.'/'.$skill->name) }}">
				{{ __($skill->name) }} <span>{{ $skill->getProfessionalCount() }}</span></a></li>
		@endforeach
		</ul>
	</div>
@endforeach
<h2>{{ __('companies') }} <span>{{ $metiers['company']['count'] }}</span></h2>
@foreach($metiers['company']['metiers'] as $metier)
	<div class='metier'>
		<h3 style="background-color: {{ $metier->color  }}"><a href="{{ url('metier/'.$metier->id.'/'.$metier->name) }}">{{ __($metier->name) }} <span>{{ $metier->getProfessionalCount() }}</span></a></h3>
		<ul>
		@foreach($metier->skills as $skill)
			<li class='skill'><a href="{{ url('skill/'.$skill->id.'/'.$skill->name) }}">
				{{ __($skill->name) }} <span>{{ $skill->getProfessionalCount() }}</span></a></li>
		@endforeach
		</ul>
	</div>
@endforeach
<h2>{{ __('halls') }} <span>{{ $metiers['hall']['count'] }}</span></h2>