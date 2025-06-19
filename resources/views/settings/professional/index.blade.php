@extends('settings.professional')

@section('form')
<form method="POST" action="{{ url('settings') }}" enctype="multipart/form-data">
    @csrf
   
    <div class="form-group row">
        <label for="avatar" class="col-md-2 col-form-label">Avatar</label>
        <div class="col-md-6">
            <input type="file" id="avatar" name="avatar" accept="image/*">                                  
        </div>
    </div> 
    
    <div class="form-group row">
        <label for="website" class="col-md-2 col-form-label">Website</label>
        <div class="col-md-6">
            <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="<?= $professional->website ?>">
            @error('website')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="description" class="col-md-2 col-form-label">Description</label>
        <div class="col-md-6">
            <textarea class="form-control" name='description'><?= $professional->description ?></textarea>
        </div>
    </div> 
    <div class="form-group row">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form> 
       
@endsection