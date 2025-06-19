<div id='zone-user-advice'>
    @if (Auth::check())
        @if(Auth::user()->id != $professional->user->id)
            <form method="POST" action="{{ url('advice/add') }}" class='form-horizontal' id='advice-form'>
                @csrf
                <div class='stars-zone strip'> 
                    <div class="stars">
                        <?php $note = 0;
                        for($i = 0; $i<$note; $i++){ ?>
                            <i id='<?php echo $i+1 ?>' class="fa fa-star-o star"></i>
                        <?php }
                        for($j = 0; $j<5-$note; $j++){ ?>
                            <i id='<?php echo $i+$j+1 ?>' class="fa fa-star-o star"></i>
                        <?php } ?>
                    </div>
                </div>
                <input type="hidden" name="score" id='score' value='0'>
                <input type="hidden" name="type" value="{{ $object['type'] }}">
                <input type="hidden" name="object" value="{{ $object['id'] }}">
                
                <div class='form-group'>
                    <label for='comment' class='control-label'>{{ __('insert_comment') }} : </label>
                    <textarea name='comment' id='comment' required></textarea>
                </div>   
                <div class='form-group'>
                    <input type='submit' value='Envoyer'>
                </div>
            </form>
        @endif
    @else
    <p id='noconnect'>{{ __('noconnect_comment') }}</p>
    @endif
</div>

<script type="text/javascript">  
  
$('#zone-user-advice .star').click(function(){
    n = $(this).attr('id');
    //id = $(this).parent().attr('id');

    $('#score').val(n);
   
    $('#zone-user-advice .star').each(function() {
      if(parseInt($(this).attr('id')) <= parseInt(n)){
        $(this).addClass('fa-star');
        $(this).removeClass('fa-star-o');
      }
      else{
        $(this).addClass('fa-star-o');
        $(this).removeClass('fa-star');
      }
    });
});

</script>