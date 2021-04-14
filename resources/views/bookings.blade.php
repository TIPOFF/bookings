@extends('support::base')

@section('content')
    {{-- DO NOT REMOVE - identity tag --}}
    <!-- M:{{ $market->id }} L:{{ $location->id }} -->

    {{-- Place holder content - safe to replace --}}
    <ul>
        <li>Market: {{ $market->name }}</li>
        <li>Location: {{ $location->name }}</li>
    </ul>
@endsection
