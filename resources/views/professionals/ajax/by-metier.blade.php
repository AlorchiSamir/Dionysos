@include('professionals.list')

{{ $professionals->appends(request()->except('page')) }}
