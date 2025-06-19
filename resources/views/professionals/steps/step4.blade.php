@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" id='results'>
                <header class="panel-heading">{{ __('your_company') }}</header>                
                  <div class="panel-body settings">
                    <form method="POST" action="{{ url('company/create') }}">
                        @csrf
                        <hr>
                        @include('companies.form')
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