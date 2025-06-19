<div class='professional-list'>
	@if(isset($count))
		<span>{{ __('results') }} : {{ $count }}</span>
	@endif
    @foreach($professionals as $professional)
    <div>   
    	<a href="{{ url('professional/'.$professional->id.'/'.$professional->slug) }}">                
	        <div class='professional strip elem-list '>
	        	<div class='picture'>
	        		<img src="{{ url('images/avatar/'.$professional->getSetting('avatar')) }}">
	        	</div>
	            <p><span class='name'>{{ $professional->surname }}</span><span class='city'>{{ $professional->address['city'] }}</span></p>    
	            <div class='description'>{{ $professional->description }}</div> 	
	            <div class='score'>
	            	@if(!is_null($professional->getAverageScore()))	
	            		<?php $object = $professional; ?>	              
		                @include('advices.entity')		          
		            @endif
	            </div>
	            @if($professional->isNew())
	            	<span class='new'>{{ __('new') }}</span>
	            @endif
	            <div class='zone-interactions'>
	            	@if(Auth::check())
		            	@if($professional->isLiked(Auth::user()->id))
		            		<div class='liked'>
	                        	<i class='fa fa-heart'></i>
	                    	</div>
		            	@endif
		            	@if($professional->isInterested(Auth::user()->id))
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