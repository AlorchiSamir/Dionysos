@extends('settings.hall')

@section('form')

<span class='title-form'>{{ __('images') }}</span>
<hr>  
<div class='img-deletable'>   
    <ul>
        @foreach($hall->images as $image)
            <li>
                <img src="{{  url('images/hall/'.$image->url) }}">
                <button class='image-delete' data-id='{{ $image->id }}'>{{ __('delete') }}</button>
            </li>
        @endforeach 
    </ul>
</div>
<span class='title-form'>{{ __('add_image') }}</span>
<hr>
<form method="POST" action="{{ url('hall/settings/'.$hall->id.'/'.$hall->slug.'/images') }}" enctype="multipart/form-data">
    @csrf


    <div class="form-group row">
        <label for="image" class="col-md-2 col-form-label">{{ __('url') }}</label>
        <div class="col-md-6">
            <input id="image" type="file" class="form-control" name="image">
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">{{ __('add') }}</button>
        </div>
    </div>
</form>    

<script type="text/javascript">  
  


</script>  
       
@endsection