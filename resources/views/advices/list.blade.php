<div class='advices-list'>
    @foreach($advices as $advice)
    <div class=''>   
    	<div class='advice strip' <?= (isset($userAdvice) && $userAdvice->id == $advice->id) ? 'id="user-advice"' : '' ?>>
    		<div class='zone-left'>
                <img class='avatar' src="{{ url('images/avatar/'.$advice->user->getSetting('avatar')) }}">
                <div class='firstname'>{{ $advice->user->firstname }}</div>
                <div class='date-pub'>{{ $advice->getIntervalDate() }}</div>
            </div>
            <div class='zone-right'>
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
                <div class='footer'>
                    <div class='vote'>
                        @if(Auth::check())
                        <span>{{ __('advice_is_useful') }}</span>
                        <div class="up <?= ($advice->isVoted(Auth::user()->id, 1)) ? 'active' : '' ?>" id='{{ $advice->id }}'
                             data-url="{{ url('user/interaction') }}" data-object='advice'>
                             <i class='fa fa-plus'></i>
                        </div>
                        <div class="down <?= ($advice->isVoted(Auth::user()->id, -1)) ? 'active' : '' ?>" 
                             id='{{ $advice->id }}' 
                             data-url="{{ url('user/interaction') }}" data-object='advice'>
                             <i class='fa fa-minus'></i>
                        </div>
                        <span>(<span class='upc'>{{ $advice->getUpVote() }}</span>/<span class='downc'>{{ $advice->getDownVote() }}</span>)</span>
                        @endif
                    </div>
                </div>
                @if($advice->status == 10)
                    <div class='status report' id='{{ $advice->id }}' 
                         data-url="{{ url('advice/report') }}">{{ __('report') }}</div>
                @elseif($advice->status == 5)
                    <div class='status reported' id='{{ $advice->id }}'>{{ __('reported') }}</div>
                @elseif($advice->status == 20)
                    <div class='status reported' id='{{ $advice->id }}'>{{ __('verified') }}</div>
                @endif
            </div>
		</div>      
    </div>
    @endforeach
</div>