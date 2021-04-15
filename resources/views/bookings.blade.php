@extends('support::base')

@section('content')
    @include('bookings::partials._identity_tag')

    {{-- Place holder content - safe to replace --}}
    <ul>
        <li>Market: {{ $market->name }}</li>
        <li>Location: {{ $location->name }}</li>
    </ul>
@endsection
