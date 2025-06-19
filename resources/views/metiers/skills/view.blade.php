@extends('layouts.app')

@section('content')
<div class='banner'>
    <div class='container'>
        <ol class="breadcrumb-nav">
            <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
            <li class="breadcrumb-item active"><a href="{{ url('/skill') }}">{{ __('skill') }}</a></li>
            <li class="breadcrumb-item active">{{ $skill->name }}</li>
        </ol>
        @include('search.form')
    </div>
</div>
<div class="container"> 
    <section class='options strip'>
       @include('metiers.options')
    </section>
    <section id='zone-professionals'>
        <h2>{{ ucfirst($metier->name) }}</h2>
        <div id='zone-list'>
            @include('professionals.list')
            {{ $professionals->links() }}
        </div>
    </section>
</div>
@endsection