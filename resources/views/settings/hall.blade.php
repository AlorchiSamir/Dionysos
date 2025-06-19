@extends('layouts.app')

@section('content')
<div class="container settings">
    <nav>
        <ul>
            <li>
                <a href="{{ url('hall/settings/'.$hall->id.'/'.$hall->slug) }}" class="<?php echo ($type == 'general') ? 'active' : '' ?>">Général
                </a>
            </li>
            <li>
                <a href="{{ url('hall/settings/'.$hall->id.'/'.$hall->slug.'/price') }}" 
                   class="<?php echo ($type == 'price') ? 'active' : '' ?>">
                Tarifs et services
                </a>
            </li>
            <li>
                <a href="{{ url('hall/settings/'.$hall->id.'/'.$hall->slug.'/address') }}"
                   class="<?php echo ($type == 'address') ? 'active' : '' ?>">Adresse</a>
            </li>
            <li>
                <a href="{{ url('hall/settings/'.$hall->id.'/'.$hall->slug.'/images') }}" 
                   class="<?php echo ($type == 'image') ? 'active' : '' ?>">Images</a>
            </li>           
        </ul>
    </nav>
    <div class='zone-form'>
        @yield('form') 
    </div>
</div>

@endsection