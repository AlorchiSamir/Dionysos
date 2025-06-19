@extends('settings.user')

@section('form')
<form method="POST" action="{{ url('settings') }}" enctype="multipart/form-data">
    @csrf
   
    <div class="form-group row">
        <label for="avatar" class="col-md-4 col-form-label text-md-right">Avatar</label>
        <div class="col-md-6">
            <input type="file" id="avatar" name="avatar" accept="image/*">                                  
        </div>
    </div>                 
    
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form>
@endsection