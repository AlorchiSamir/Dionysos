@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" id='results'>
                <header class="panel-heading">{{ __('choice_your') }} {{ __('skills') }}</header>                
                  <div class="panel-body settings">
                    @include('metiers.skills.form')                   
                </div>
            </div>       
            </div>
        </div>
    </div>
</div>
@endsection