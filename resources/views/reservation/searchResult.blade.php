@extends('layouts.app')
@section('content')
<h1>Søkeresultat</h1>

    @if (count($hotels)< 1)
        <p>Ingen resultat passet dine instillinger. Prøv igjen</p>
    @else
        @foreach ($hotels as $hotel)
            <form name="create" role="form" method="get" action="{{ action('ReservationController@create') }}">
                @csrf
                <h2>{{$hotel->name}}</h2>
                <p>Pris: {{$hotel->price}}</p>
                <input type="hidden" name="hotelId" value="{{$hotel->hotelId}}">
                <input type="hidden" name="numRooms" value="{{$numRooms}}">
                <input type="hidden" name="toDate" value="{{$toDate}}">
                <input type="hidden" name="fromDate" value="{{$fromDate}}">
                <button>Book</button>
            </form>
        @endforeach
    @endif
@endsection
