<div id='metiers'>
	@foreach($metiers as $metier)
	    <div class="col-md-2 book">                   
	        <div class='cover'>
	            <div class='metier-step2' data-url='{{ url("/metier/type/".$metier->id) }}'>{{ $metier->name }}</a>
	        </div>              
	    </div>
	@endforeach
</div>

<script type="text/javascript">
	
$(function(){
    
	$('.metier-step2').click(function(){
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