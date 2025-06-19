<div class="stars">
    <?php $note = (is_array($object)) ? $object['average'] : $object->getAverageScore();
    	  $reste = fmod($note,1);
    for($i = 0; $i<floor($note); $i++){ ?>
  	    <i class="fa fa-star gold star"></i>
    <?php }
    if($reste > 0 && $reste < 0.2){ ?>
    	<i class="fa fa-star-o star"></i>
    <?php }
    else if($reste >= 0.8){ ?>
    	<i class="fa fa-star star"></i>
    <?php }
    else if($reste > 0.2 && $reste < 0.8){ ?>
    	<i class="fa fa-star-half-o star"></i>
    <?php }
    for($j = 0; $j<5-ceil($note); $j++){ ?>
    	<i class="fa fa-star-o star"></i>
    <?php } ?>
</div>