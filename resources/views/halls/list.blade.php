<div class='hall-list'>
	@if(isset($count))
		<span class='results-count'>{{ __('results') }} : {{ $count }}</span>
	@endif
	@foreach($halls as $hall)
	<div>   
    	<a href="{{ url('hall/'.$hall->id.'/'.$hall->slug) }}">
			<div class='hall strip elem-list'>
				<div class='picture'>
	        		<img src="{{ url('images/hall/default.jpg') }}">
	        	</div>
				<div><span class='name'>{{ $hall->name }}</span><span class='city'>{{ $hall->address['city'] }}</span></div>
				<div class='description'>{{ $hall->description }}</div> 	
	            <div class='score'>
	            	@if(!is_null($hall->getAverageScore()))	
	            		<?php $object = $hall; ?>	              
		                @include('advices.entity')		          
		            @endif
	            </div>
	            @if($hall->isNew())
	            	<span class='new'>{{ __('new') }}</span>
	            @endif
				<div class='zone-interactions'>
	            	@if(Auth::check())
		            	@if($hall->isLiked(Auth::user()->id))
		            		<div class='liked'>
	                        	<i class='fa fa-heart'></i>
	                    	</div>
		            	@endif
		            	@if($hall->isInterested(Auth::user()->id))
		            		<div class='interested'>
	                        	<i class='fa fa-bookmark'></i>
	                    	</div>
		            	@endif
	            	@endif
	            </div>
			</div>
		</a>
	</div>
	@endforeach
</div>