@extends('settings.professional')

@section('form')
       
<form method="POST" action="{{ url('address/update/'.$professional->address->id) }}">
    @csrf
    @include('address.form')
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form>         
       
@endsection