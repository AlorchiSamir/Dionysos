@extends('layouts.app')

@section('content')
<div class='banner'>
    <div class='container'>
        <ol class="breadcrumb-nav">
            <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>            
            <li class="breadcrumb-item active">{{ __('search') }}</li>
        </ol>
        @include('search.form')
    </div>
</div>
<div class="container">	
    <section class='options strip'>
	   @include('metiers.options')
    </section>
    <section id='zone-professionals'> 
        @if(!is_null(Auth::user()))
            <div class='set-register-query'>{{  __('set_register_query') }}</div>  
            @if(Auth::user()->getSetting('search') != 'empty')
                <a href="{{ url('search'.Auth::user()->getSetting('search')) }}">{{ __('get_register_query') }}</a>
            @endif
        @endif     
        <div id='results'>
            @if(isset($metier->name) && isset($city))
                <h2>{{ __($metier->name).' '.__('from').' '.$city }}</h2>
            @elseif(isset($metier->name))
                <h2>{{ __($metier->name) }}</h2>
            @elseif(isset($city))
                <h2>{{ __($type).' '.__('from').' '.$city }}</h2>
            @else
                <h2>{{ __($type) }}</h2>
            @endif            
            <input type="text" name="name" id='searchbyname' value='<?= (isset($_GET['name'])) ? $_GET['name'] : '' ?>'
                   placeholder='Recherche par nom' autocomplete="off">
            @if(count($professionals) > 0)
            <div id='zone-list'>
                @include('professionals.list')
                {{ $professionals->appends(request()->except('page')) }}
            </div>
            @else
            <div>{{ __('no_result') }} {{ __('from') }} {{ $city }}</div>
            @endif
        </div>
        @if(isset($other_professionals) && count($other_professionals) > 0)
        <div id='other_results'>
            <h2>{{ __('other_results').' '.$city }}</h2>
            <div id='zone-list'>
                <?php  $professionals = $other_professionals; ?>
                @include('professionals.list')
            </div>
        </div>
        @endif
    </section>
</div> 
<input type="hidden" class="metier_id" value="<?= (isset($metier->id)) ? $metier->id : 'empty' ?>">

<script>
    $(function(){
        $('#searchbyname').keyup(function() {
            var skills = [];
            var city = '<?php echo (isset($city)) ? $city : ''; ?>';

            metier_id = $('.metier_id').val();

            $('input:checked[class=skill]').each(function() {
              skills.push($(this).attr('id'));
            });
            if(skills.length === 0){
                value = 'empty';
            }
            else{
                value = skills;
            }
            var search = $(this).val();   

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: "{{ url('/person/searching') }}",
                data: {
                    'name' : search,
                    'skills': value,
                    'metier': metier_id,
                    'city' : city
                },
                success: function(data){
                    $('#results #zone-list').html(data);
                },
                error:function(jqXHR, textStatus){
                    console.log(jqXHR);            
                }
            });             
        });   

        $('.set-register-query').click(function(){
            var skills = [];
            var city = '<?php echo (isset($city)) ? $city : ''; ?>';

            metier_id = $('.metier_id').val();

            $('input:checked[class=skill]').each(function() {
              skills.push($(this).attr('id'));
            });
            if(skills.length === 0){
                value = 'empty';
            }
            else{
                value = skills;
            }
            var search = $('#searchbyname').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: "{{ url('/search/register') }}",
                data: {
                    'name' : search,
                    'skills': value,
                    'metier': metier_id,
                    'city' : city
                },
                success: function(data){
                    
                },
                error:function(jqXHR, textStatus){
                    console.log(jqXHR);            
                }
            }); 


        });

    });
</script>

@endsection