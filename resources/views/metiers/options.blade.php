<div>{{ __('skills') }}</div>
<hr>
<ul class='skills'>
    @if(isset($metiers))
        <select id='metiers'>
            <option value='0'>{{ __('all') }}</option>      
            @foreach($metiers as $_metier)       
                <option value='{{ $_metier->id }}' <?= (isset($metier) && $metier->id == $_metier->id) ? 'selected' : '' ?>>{{ __($_metier->name) }}</option>      
            @endforeach
        </select>
    @endif
    <div id='options-skills'>
    @if(isset($metier->skills))
    	@foreach($metier->skills as $_skill)
    	<li>
    		<input type="checkbox" class='skill' id='{{ $_skill->id }}'
            <?php echo ((isset($skill) && $_skill->id == $skill->id) || (isset($skills) && $skills != 'empty' && in_array($_skill->id, $skills))) ? 'checked' : '' ?>>
    		<label for='{{ $_skill->id }}'>{{ $_skill->name }}</label>
    	</li>
    	@endforeach
    @endif
    </div>
</ul>

<script>
    $(function(){

    	var skills = [];                

        @if(isset($skill))
        skills.push('{{ $skill->id }}');
        @endif

        @if(isset($skills) && $skills != 'empty')
            @foreach($skills as $_skill)
                skills.push('{{ $_skill }}');
            @endforeach
        @endif

        @if(!isset($metier->id))
            metier_id = 'empty';
        @else
            metier_id = {{ $metier->id }}
        @endif

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
                    },
                    error:function(jqXHR, textStatus){
                      console.log(jqXHR);            
                    }
                });


            }
            else{
                $('#options-skills').empty();
            }
            
        });

        $('.skill').change(function (){
        	var id = $(this).attr('id');
        	var city = '<?php echo (isset($city)) ? $city : ''; ?>';
            var name = $('#searchbyname').val();
        	if($(this).prop("checked") == true){
        		skills.push(id);
        	}
        	else{
        		for (var i = 0; i < skills.length; i++){
        			if (skills[i] === id) { 
				        skills.splice(i, 1);
				        break;
				    }
        		}				    
        		skills.splice(i,1);;
        	}
        	if(skills.length === 0){
        		value = 'empty';
        	}
        	else{
        		value = skills;
        	}
        	$.ajax({
	  			headers: {
	    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  			},
	            method: 'POST',
	            url: "{{ url('/'.$type.'/searching') }}",
	            data: {
		            'skills': value,
                    'name' : name,
		            'metier': metier_id,
		            'city' : city
	        	},
	        	success: function(data){
            		$('#results #zone-list').html(data);
            	},
                error:function(jqXHR, textStatus){
                  console.log(jqXHR);            
                }
	        });
            if (document.getElementById('other_results')){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    url: "{{ url('/'.$type.'/rangeBySkillsAndCities') }}",
                    data: {
                        'skills': value,
                        'metier': metier_id,
                        'city' : city
                    },
                    success: function(data){
                        $('#other_results #zone-list').html(data);
                    }
                });
            }
        });
    });       
        
</script>