@extends('settings.hall')

@section('form')
<form method="POST" action="{{ url('hall/settings/'.$hall->id.'/'.$hall->slug) }}" enctype="multipart/form-data">
    @csrf   
     
    <div class="form-group row">
        <label for="website" class="col-md-2 col-form-label">Website</label>
        <div class="col-md-6">
            <input id="name" type="text" class="form-control" name="name" value="<?= $hall->name ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="description" class="col-md-2 col-form-label">Description</label>
        <div class="col-md-6">
            <textarea class="form-control" name='description'><?= $hall->description ?></textarea>
        </div>
    </div> 
    <div class="form-group row">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form> 
       
@endsection