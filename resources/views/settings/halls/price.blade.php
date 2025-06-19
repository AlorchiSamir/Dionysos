@extends('settings.hall')

@section('form')
       
<form method="POST" action="{{ url('hall/settings/'.$hall->id.'/'.$hall->slug.'/price') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label for="price" class="col-md-2 col-form-label">Tarif</label>
        <div class="col-md-3">
            <input id="price" type="number" class="form-control" name="price" 
                   value="<?= (isset($hall->price->price)) ? $hall->price->price : '' ?>" placeholder="0">
        </div>
        <div class="col-md-3">
            <select name="type" id="type" class="form-control">
                <option value="hour">€/Heure</option>
                <option value="forfait" <?php echo (isset($hall->price->type) 
                    && $hall->price->type == 'forfait') ? 'selected' : '' ?>>Forfait</option>
            </select>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form>         
       
@endsection