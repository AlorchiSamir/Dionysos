@extends('settings.professional')

@section('form')
       
<form method="POST" action="{{ url('settings/price') }}" enctype="multipart/form-data">
    @csrf
   
   	<div class="form-group row">
        <label for="distance" class="col-md-2 col-form-label">Périmètre</label>
        <div class="col-md-6">
            <input id="distance" type="number" class="form-control" name="distance" value="<?= $settings['distance'] ?>" placeholder="KM">
        </div>
    </div>
    <div class="form-group row">
        <label for="price" class="col-md-2 col-form-label">Tarif</label>
        <div class="col-md-3">
            <input id="price" type="number" class="form-control" name="price" 
                   value="<?= (isset($professional->price->price)) ? $professional->price->price : '' ?>" placeholder="0">
        </div>
        <div class="col-md-3">
            <select name="type" id="type" class="form-control">
                <option value="hour">€/Heure</option>
                <option value="forfait" <?php echo (isset($professional->price->type) 
                    && $professional->price->type == 'forfait') ? 'selected' : '' ?>>Forfait</option>
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