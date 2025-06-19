@extends('layouts.app')

@section('content')
<div class='banner'>
  <div class="container">
      <ol class="breadcrumb-nav">
          <li class='breadcrumb-item'><a href="{{ url('/') }}">{{ __('home') }}</a></li>
          <li class="breadcrumb-item"><a href="{{ url('/company') }}">{{ __('companies') }}</a></li>
          <li class="breadcrumb-item active">{{ $company->name }}</li>
      </ol>
      @include('search.form')
  </div>
</div>
<div class="container company view">
  <header class='strip'> 
      <div class='interactions'>                        
        <div class='zone-like'>
            @if(Auth::check())
                @if($company->isLiked(Auth::user()->id))
                    <div class='like liked' id='{{ $company->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='company'>
                         <i class='fa fa-heart'></i>
                    </div>
                    <div class='like noliked' id='{{ $company->id }}' 
                         data-url="{{ url('user/interaction') }}" data-objetc='company' style='display: none;'>
                         <i class='fa fa-heart'></i>
                    </div>                            
                @else
                    <div class='like liked' id='{{ $company->id }}' 
                         data-url="{{ url('user/interaction') }}" data-object='company' style='display: none;'>
                         <i class='fa fa-heart'></i>
                    </div>
                    <div class='like noliked' id='{{ $company->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='company'>
                         <i class='fa fa-heart'></i>
                    </div>
                @endif                                        
            @else
                <div class='like'><i class='fa fa-heart'></i></div>
            @endif
            <div class='total'>{{ $company->getLikes() }}</div>
        </div>
        <div class='zone-interest'>
            @if(Auth::check())
                @if($company->isInterested(Auth::user()->id))
                   <div class='interest interested' id='{{ $company->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='company'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                    <div class='interest nointerested' id='{{ $company->id }}' 
                         data-url="{{ url('user/interaction') }}" data-objetc='company' style='display: none;'>
                         <i class='fa fa-bookmark'></i>
                    </div>                            
                @else
                    <div class='interest interested' id='{{ $company->id }}' 
                         data-url="{{ url('user/interaction') }}" data-object='company' style='display: none;'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                    <div class='interest nointerested' id='{{ $company->id }}'
                         data-url="{{ url('user/interaction') }}" data-object='company'>
                         <i class='fa fa-bookmark'></i>
                    </div>
                @endif
            @else
                <div class='interest'><i class='fa fa-bookmark'></i></div>
            @endif
            <div class='total'>{{ $company->getInterests() }}</div>
        </div>    
     </div>


      <div class='zone-description'>
          <h1>{{ $company->name }}
            @if(!is_null($company->getAverageScore()))
              <a href='#zone-advices' class='score'>
                @include('advices.entity')
                <span class='count'>{{ count($company->getAdvices()) }} avis</span>
              </a>
            @endif
          </h1>
         
          <div>
            @if($company->description != '')
              {{ $company->description }}  
            @else
                {{ __('no_description') }}
            @endif
          </div>
     </div>


     <div id="button-modal-pro" class='message-button'>{{ __('send_message') }}</div>
  </header>
  
  <section>
    <aside>

      <div class='contact-person bloc strip'>
        <h4>{{ __('contact_person') }}</h4>
        <hr>
        <ul>
          <li><img class='avatar' src="{{ url('images/avatar/'.$professional->getSetting('avatar')) }}"></li>
          <li>{{ $professional->user->firstname.' '.$professional->user->name }}</li>
          <li>{{ $professional->email }}</li>
          <li>{{ $professional->tel }}</li>
        </ul>
      </div>

     
      <div class='informations bloc strip'>
        <h4>{{ __('informations') }}</h4>
        <hr>
        <ul>
          <li><?php echo ($address) ? $address->formatage() : 'Aucune adresse' ?></li>
          <li>{{ $company->capacity }}</li>
          @if($company->parking)
            <li>{{ __('parking') }}</li>
          @endif
          <li><?php echo (!is_null($professional->website)) ? '<a href="'.$professional->website.'">Site Web</a>' : 'Aucun site' ?></li>
        </ul>
       </div>     
    </aside>
    <section>
     
      <div class='zone-map'>
        <h3>{{ __('map') }}</h3>
        @if(isset($address->latitude) && isset($address->longitude))
          <div id='map' data-x='{{ $address->latitude }}' data-y='{{ $address->longitude }}'></div>
        @endif
        
      </div>
      <div id='zone-advices'>
      @if(!$userAdvice)
        @include('advices.form')
      @endif
        @include('advices.list')
      </div>
    </section>  
 </section>
</div>
@include('messages.modals.professional')

<script>
    window.onload = function(){

        var x = $('#map').data('x');
        var y = $('#map').data('y');
        

        var map = L.map('map').setView([x, y], 13);
        var tileStreet = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            center: [x, y],
            maxZoom: 15,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1Ijoic2FtaXJhbG9yY2hpIiwiYSI6ImNrMHdqMnhqMjAza3AzaW1tZzU2NHhmaTIifQ.G1Ycxbr7vaDqsoWz3aowyg'
        });
        tileStreet.addTo(map);

        var marker = L.marker([x, y]).addTo(map);

        marker.bindPopup("<?php echo $professional->surname ?>");
    }  



   
      $('#button-modal-pro').click(function() {
          $('#message-modal-pro').modal();
      });
  
       $(document).on('submit', '#message-pro-form', function(e) {  
            e.preventDefault();
              
            $('input+small').text('');
            $('input').parent().removeClass('has-error');
              
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                //dataType: "json"
            })
            .done(function(data) {
                console.log(data);
                $('.alert-success').removeClass('hidden');
                $('#message-modal-pro').modal('hide');
            })
            .fail(function(data) {
                console.log(data);
                $.each(data.responseJSON, function (key, value) {
                    var input = '#message-form input[name=' + key + ']';
                    $(input + '+small').text(value);
                    $(input).parent().addClass('has-error');
                });
            });
        }); 

        
</script>

@endsection

