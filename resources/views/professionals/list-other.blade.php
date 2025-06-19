<div class='professional-list'>
    @foreach($other_professionals as $professional)
    <div>   
    	<a href="{{ url('professional/'.$professional->id.'/'.$professional->slug) }}">                
	        <div class='professional strip elem-list '>
	        	<div class='avatar'>
	        		<img src="{{ url('images/avatar/'.$professional->getSetting('avatar')) }}">
	        	</div>
	            <p><span class='name'>{{ $professional->surname }}</span><span class='city'>{{ $professional->address['city'] }}</span></p>    
	            <div class='description'>{{ $professional->description }}</div> 	
	            <div class='score'>
	            	@if(!is_null($professional->getAverageScore()))		              
		                @include('advices.entity')		          
		            @endif
	            </div>
	        </div>  
        </a>            
    </div>
    @endforeach
    
</div>