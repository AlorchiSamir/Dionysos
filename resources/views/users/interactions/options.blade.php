<section class='options strip'>
	<div>{{ __('filter') }}</div>
	@if(isset($metiers))
	<select id='metiers'>
		<option value='{{ $category }}'>{{ __('all') }}</option>		
		@foreach($metiers as $metier)		
			<option value='{{ $metier->id }}'>{{ ucfirst($metier->name) }}</option>		
		@endforeach
	</select>
	<div id='options-skills'>
    </div>
	@endif	
</section>

<script>
    $(function(){

    	var metiers = [];

        $('#metiers').change(function (){
        	var id = $(this).val();
        	var name = $('#metiers option:selected').text();
        	console.log(name);
        	if(id == 'professional' || id == 'company' || id == 'hall'){
        		$.ajax({
		  			headers: {
		    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  			},
		            method: 'POST',
		            url: "{{ url('/interaction/allMetier') }}",
		            data: {
			            'metier': id
		        	},
		        	success: function(data){
		        		$('#zone-result').html(data);
	            	},
	            	error:function(jqXHR, textStatus){
		             console.log(jqXHR);            
        			}
		        });
        	}
        	else{
        	
	        	$.ajax({
		  			headers: {
		    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  			},
		            method: 'POST',
		            url: "{{ url('/interaction/rangeByMetier') }}",
		            data: {
			            'metier': id
		        	},
		        	success: function(data){
		        		$('#zone-metiers').html(data);
		        		$('#zone-metiers').prepend('<h3>'+name+'</h3>');
	            	}
		        });
        	}
	        
        });
    });    
</script>   
        
