@extends('layouts.app')

@section('content')
<div class="container settings">
    <nav>
        <ul>
            <li>
                <a href="{{ url('settings') }}" class="<?php echo ($type == 'general') ? 'active' : '' ?>">Général</a>
            </li>
            <li>
                <a href="{{ url('settings/price') }}" class="<?php echo ($type == 'price') ? 'active' : '' ?>">Tarifs et services</a>
            </li>
            <li>
                <a href="{{ url('settings/address') }}" class="<?php echo ($type == 'address') ? 'active' : '' ?>">Adresse</a>
            </li>
            <li>
                <a href="{{ url('settings/videos') }}"  class="<?php echo ($type == 'video') ? 'active' : '' ?>">Videos</a>
            </li>
            <li>
                <a href="{{ url('settings/networks') }}"  class="<?php echo ($type == 'network') ? 'active' : '' ?>">Réseaux sociaux</a>
            </li>
        </ul>
    </nav>
    <div class='zone-form'>
        @yield('form') 
    </div>
</div>

@endsection