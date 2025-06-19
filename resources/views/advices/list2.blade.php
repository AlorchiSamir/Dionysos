<div class='advices-list'>
    @foreach($advices as $advice)
    <div class=''>  
        <?php $object = $advice->getObject() ?>
        <a href="{{ url($advice->type.'/'.$object->id.'/'.$object->slug.'#user-advice') }}">  
        	<div class='advice strip elem-list2'>
        		<img class='avatar' src="{{ url('images/avatar/'.$advice->user->getSetting('avatar')) }}">
                <span>{{ $object->name }}</span>
    			<div class='score'>
    				<div class="stars">
                        <?php $note = $advice->score;
                        for($i = 0; $i<$note; $i++){ ?>
                            <i id='<?php echo $i+1 ?>' class="fa fa-star star"></i>
                        <?php }
                        for($j = 0; $j<5-$note; $j++){ ?>
                            <i id='<?php echo $i+$j+1 ?>' class="fa fa-star-o star"></i>
                        <?php } ?>
                    </div>
    			</div>
    			<p><span class='comment'>{{ $advice->comment }}</span></p>            
    		</div> 
        </a>     
    </div>
    @endforeach
</div>