@if(isset($_professionals))    
    <section id='professionals'>
        @if(count($_professionals) > 0)
            <h2>{{ __('professionals') }}</h2>
            <hr>
            <div id='zone-metiers'>
                @foreach($_professionals as $id => $professionals)
                    <h3>{{ ucfirst($metiers[$id]->name) }}</h3>
                    <div id='zone-list'>
                        @include('professionals.list')
                    </div>
                @endforeach
            </div>
        @else
            <div class='zone-not-result'>{{ __('not-'.$type) }}</div>
        @endif
    </section>
@endif
@if(isset($_companies))
    <section id='companies'>
        @if(count($_companies) > 0)
            <h2>{{ __('companies') }}</h2>
            <hr>
            <div id='zone-metiers'>
                @foreach($_companies as $id => $companies)
                    <h3>{{ ucfirst($metiers[$id]->name) }}</h3>
                    <div id='zone-list'>
                        @include('companies.list')
                    </div>
                @endforeach
            </div>
        @else
            <div class='zone-not-result'>{{ __('not-'.$type) }}</div>
        @endif
    </section>
@endif
@if(isset($halls))
    <section id='halls'>
        @if(count($halls) > 0)
            <h2>{{ __('halls') }}</h2>
            <hr>
            <div id='zone-list'>
                @include('halls.list')
            </div>
        @else
            <div class='zone-not-result'>{{ __('not-'.$type) }}</div>
        @endif
    </section>
@endif