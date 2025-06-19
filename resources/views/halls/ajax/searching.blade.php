@include('halls.list')
@if($pagination)
{{ $halls->appends(request()->except('page')) }}
@endif