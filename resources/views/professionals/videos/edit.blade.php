@extends('settings.professional')

@section('form')
       
<form method="POST" action="{{ url('settings/videos') }}" enctype="multipart/form-data">
    @csrf
   
    <div class="form-group row">
        <label for="url" class="col-md-2 col-form-label">{{ __('url') }}</label>
        <div class="col-md-6">
            <input id="url" type="text" class="form-control" name="url">
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">{{ __('add') }}</button>
        </div>
    </div>
</form>      
       
@endsection