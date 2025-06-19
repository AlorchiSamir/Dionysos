@extends('settings.professional')

@section('form')
       
<form method="POST" action="{{ url('settings/networks') }}" enctype="multipart/form-data">
    @csrf
   
    <div class="form-group row">
        <label for="facebook" class="col-md-2 col-form-label">Facebook</label>
        <div class="col-md-6">
            <input id="facebook" type="text" class="form-control" name="networks[facebook]" 
                   value="<?= isset($social_networks['facebook']) ? $social_networks['facebook'] : '' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="twitter" class="col-md-2 col-form-label">Twitter</label>
        <div class="col-md-6">
            <input id="twitter" type="text" class="form-control" name="networks[twitter]"
                   value="<?= isset($social_networks['twitter']) ? $social_networks['twitter'] : '' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="instagram" class="col-md-2 col-form-label">Instagram</label>
        <div class="col-md-6">
            <input id="instagram" type="text" class="form-control" name="networks[instagram]"
                   value="<?= isset($social_networks['instagram']) ? $social_networks['instagram'] : '' ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="tiktok" class="col-md-2 col-form-label">TikTok</label>
        <div class="col-md-6">
            <input id="tiktok" type="text" class="form-control" name="networks[tiktok]"
                   value="<?= isset($social_networks['tiktok']) ? $social_networks['tiktok'] : '' ?>">
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">{{ __('validate') }}</button>
        </div>
    </div>
</form>      
       
@endsection