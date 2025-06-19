@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" id='results'>
                <header class="panel-heading">{{ __('add_hall') }}</header>                
                  <div class="panel-body settings">
                    <form method="POST" action="{{ url('hall/create') }}">
                        @csrf
                        <hr>
                        @include('halls.form')
                        <div class='form-group'>
                            <button type="submit" class="btn btn-primary">{{ __('add') }}</button>
                        </div>
                    </form>                    
                </div>
            </div>       
            </div>
        </div>
    </div>
</div>
@endsection