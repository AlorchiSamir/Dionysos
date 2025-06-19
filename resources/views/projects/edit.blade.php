@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" id='results'>
                <header class="panel-heading">Ajouter un projet</header>                
                  <div class="panel-body settings">
                    <form method="POST" action="{{ url('project/create') }}">
                        @csrf
                        <hr>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nom</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class='form-group'>
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </form>                    
                </div>
            </div>       
            </div>
        </div>
    </div>
</div>
@endsection