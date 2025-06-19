<section class='options strip'>
	<div>{{ __('skills') }}</div>
	<hr>
	<select id='metiers'>
		<option value='0'>{{ __('all') }}</option>		
		@foreach($metiers as $metier)		
			<option value='{{ $metier->id }}'>{{ __($metier->name) }}</option>		
		@endforeach
	</select>
	<div id='options-skills'>
    </div>
</section>

<script>
    $(function(){

    	var metiers = [];

        $('#metiers').change(function (){
        	var id = $(this).val();
        	if(id == 0){
        		id = 'empty';
        	}
        	var city = '<?php echo (isset($city)) ? $city : ''; ?>';
        	
        	$.ajax({
	  			headers: {
	    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  			},
	            method: 'POST',
	            url: "{{ url('/person/searching') }}",
	            data: {
		            'metier': id,
		            'city' : city
	        	},
	        	success: function(data){
            		$('#zone-list').html(data);
            		$('.metier_id').val(id);
            	},
            	error:function(jqXHR, textStatus){
	              console.log(jqXHR);            
	            }
	        });

	        if(id != 'empty'){
	        	$.ajax({
		  			headers: {
		    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  			},
		            method: 'POST',
		            url: "{{ url('/metier/getOptions') }}",
		            data: {
			            'metier': id
		        	},
		        	success: function(data){
	            		$('#options-skills').html(data);
	            	}
	        	});


	        }
	        else{
	        	$('#options-skills').empty();
	        }

	        
        });
    });    
</script>   
        
