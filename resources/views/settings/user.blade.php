@extends('layouts.app')

@section('content')
<div class="container settings">
    <nav>
        <ul>
            <li><a href="{{ url('settings') }}">Général</a></li>
        </ul>
    </nav>
    <div class='zone-form'>
        @yield('form') 
    </div>
</div>

@endsection