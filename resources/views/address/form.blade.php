<div class="row form-group{{ $errors->has('city') ? ' has-error' : '' }}">
    <label for="tel" class="col-md-2 col-form-label">{{ __('city') }}</label>
    <div class="col-md-6">
    	<input id="city" type="text" class="form-control" name="city" value="{{ isset($address) ? $address->city : '' }}">
	</div>
</div>

<div class="row form-group{{ $errors->has('postalcode') ? ' has-error' : '' }}">
    <label for="postalcode" class="col-md-2 col-form-label">{{ __('postalcode') }}</label> 
    <div class="col-md-6">      
    	<input id="postalcode" type="text" class="form-control  @error('postalcode') is-invalid @enderror" name="postalcode" value="{{ isset($address) ? $address->postal_code : '' }}">
        @error('postalcode')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
	</div>
</div>

<div class="row form-group{{ $errors->has('street') ? ' has-error' : '' }}">
    <label for="street" class="col-md-2 col-form-label">{{ __('street') }}</label>
    <div class="col-md-6"> 
    	<input id="street" type="text" class="form-control" name="street" value="{{ isset($address) ? $address->street : '' }}"> 
    </div>
</div>

<!--<div class="row form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
    <label for="numero" class="col-md-4 col-form-label text-md-right">Numéro</label>   
    <div class="col-md-6">   
    	<input id="numero" type="text" class="form-control" name="numero" value="{{ isset($address) ? $address->numero : '' }}">
    </div>
</div>-->