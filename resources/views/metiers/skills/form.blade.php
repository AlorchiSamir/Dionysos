<a href='{{ url("/step/2") }}'>{{ __('return') }}</a>
<div id='skills'>
  <form method="POST" action="{{ url('professional/skill/add') }}">
    @csrf
  	@foreach($skills as $skill)
  	  <input type="checkbox" class='skill' name='skill[{{ $skill->metier_id }}][{{ $skill->id }}]'
             id='skill[{{ $skill->id }}]' value='{{ $skill->metier_id }}'>
        <label for='skill[<?= $skill->id ?>]'>{{ $skill->name }}</label>
      </input>	       
  	@endforeach
    <div class='form-group'>
      <button type="submit" class="btn btn-primary">{{ __('validate') }}</button>
    </div>
  </form>
</div>