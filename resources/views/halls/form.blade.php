<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('name') }}</label>
    <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name">
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
   
