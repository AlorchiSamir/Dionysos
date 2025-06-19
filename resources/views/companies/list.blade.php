<div class='company-list'>
	@if(isset($count))
		<span class='results-count'>{{ __('results') }} : {{ $count }}</span>
	@endif
	
	@foreach($companies as $company)
	<div>   
    	<a href="{{ url('company/'.$company->id.'/'.$company->slug) }}">
			<div class='company strip elem-list'>
				<div class='picture'>
	        		<img src="{{ url('images/company/default.jpg') }}">
	        	</div>
				<div><span class='name'>{{ $company->name }}</span><span class='city'>{{ $company->address['city'] }}</span></div>
				<div class='description'>{{ $company->description }}</div> 	
	            <div class='score'>
	            	@if(!is_null($company->getAverageScore()))	
	            		<?php $object = $company; ?>	              
		                @include('advices.entity')		          
		            @endif
	            </div>
	            @if($company->isNew())
	            	<span class='new'>{{ __('new') }}</span>
	            @endif
				<div class='zone-interactions'>
	            	@if(Auth::check())
		            	@if($company->isLiked(Auth::user()->id))
		            		<div class='liked'>
	                        	<i class='fa fa-heart'></i>
	                    	</div>
		            	@endif
		            	@if($company->isInterested(Auth::user()->id))
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