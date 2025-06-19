@include('companies.list')

{{ $companies->appends(request()->except('page')) }}