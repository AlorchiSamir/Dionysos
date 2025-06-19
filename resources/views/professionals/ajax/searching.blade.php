@include('professionals.list')
@if($pagination)
{{ $professionals->appends(request()->except('page')) }}
@endif