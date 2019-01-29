@extends('layouts.app')
@section('content')
<h1>Søk</h1>

<form name="search" role="form" method="post" action="{{ action('ReservationController@performSearch') }}">
    @csrf

    <div class="form-group">
        <label>By*</label>
        <select name="city" id="city">
            <option value="default">Velg by</option>
            @foreach ($cities as $city)
                <option
                {{old('city') == $city->city ? "selected" : ""}}
                value="{{$city->city}}">{{$city->city}}</option>
            @endforeach
    </select>
    </div>

    <div class="form-group">
        <label>Fra*</label>
        <input type="date" name="fromDate" id="fromDate" value="{{old('fromDate')}}">
    </div>

    <div class="form-group">
        <label>Til*</label>
        <input type="date" name="toDate" id="toDate" value="{{old( 'toDate')}}">
    </div>


    <div class="form-group">
            <label>Antall rom*</label>
            <input type="number" name="numRooms" id="numRooms" min="1" value="{{old('numRooms')}}">
        </div>

    <div class="form-group">
            <label>Makspris (per rom per natt)</label>
            <input type="number" name="maxPrice" id="maxPrice" value="{{old( 'maxPrice')}}">
        </div>


    <button type="submit" value="submit">Søk</button> @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <p>{{ $error }}
                <p>
                    @endforeach
        </ul>
    </div>
    @endif

</form>
@endsection
