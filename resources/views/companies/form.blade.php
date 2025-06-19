<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('name') }}</label>
    <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name">
    </div>
</div>

<div class="form-group row">
    <label for="tva_number" class="col-md-4 col-form-label text-md-right">{{ __('tva_number') }}</label>
    <div class="col-md-6">
        <input id="tva_number" type="text" class="form-control" name="tva_number">
    </div>
</div>

<div class="form-group row">
    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('description') }}</label>
    <div class="col-md-6">
        <textarea class="form-control" name='description'></textarea>
    </div>
</div>

<hr>
@include('address.form')
   
