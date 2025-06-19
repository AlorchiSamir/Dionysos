@extends('settings.hall')

@section('form')
       
<form method="POST" action="{{ url('address/hall/update/'.$hall->id.'/'.$hall->slug) }}">
    @csrf
    @include('address.form')
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form>         
       
@endsection