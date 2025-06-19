@include('companies.list')

@if($pagination)
{{ $companies->appends(request()->except('page')) }}
@endif