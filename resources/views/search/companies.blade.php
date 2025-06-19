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
<div class='container'>
    <section class='options strip'>
       @include('metiers.options')
    </section>
	<section id='zone-companies'>
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
            @if(count($companies) > 0)
            <div id='zone-list'>
                @include('companies.list')
                {{ $companies->appends(request()->except('page')) }}
            </div>
            @else
                <div>{{ __('no_result') }} {{ __('from') }} {{ $city }}</div>
            @endif
        </div>
        @if(count($other_companies) > 0)
        <div id='other_results'>
            <h2>{{ __('other_results').' '.$city }}</h2>
            <div id='zone-list'>
                <?php  $companies = $other_companies; ?>
                @include('companies.list')
            </div>
        </div>
        @endif
    </section>
</div>


<script>
    $(function(){
        $('#searchbyname').keyup(function() {
            var skills = [];
            var city = '<?php echo (isset($city)) ? $city : ''; ?>';

            @if(!isset($metier->id))
                metier_id = 'empty';
            @else
                metier_id = {{ $metier->id }}
            @endif

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
                url: "{{ url('/company/searching') }}",
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
    });
</script>
@endsection