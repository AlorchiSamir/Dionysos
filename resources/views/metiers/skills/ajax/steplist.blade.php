<div class='return' data-url='{{ url("/metier") }}'>{{ __('return') }}</div>
<div id='types'>
  <form method="POST" action="{{ url('professional/type/add') }}">
    @csrf
  	@foreach($types as $type)
  	  <input type="checkbox" class='type' name='type[{{ $type->metier_id }}][{{ $type->id }}]'
             id='type[{{ $type->id }}]' value='{{ $type->metier_id }}'>
        <label for='type[<?= $type->id ?>]'>{{ $type->name }}</label>
      </input>	       
  	@endforeach
    <div class='form-group'>
      <button type="submit" class="btn btn-primary">{{ __('validate') }}</button>
    </div>
  </form>
</div>

<script type="text/javascript">
	
$(function(){
    
	$('.return').click(function(){
  		id = $(this).attr('id');
  		url = $(this).data('url');
  		$.ajax({
  			headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			},
            method: 'POST',
            url: url,
            success: function(data){
            	$('#area').html(data);
            }
        });
	});

});

</script>