@extends('layouts.app')
@section('content')
<h1>Reservasjon</h1>


<form name="createReservation" role="form" method="post" action="{{ action('ReservationController@createReservation') }}">
    @csrf

    <div class="form-group">
        <label>Fornavn*</label>
        <input type="text" name="firstName" id="firstName" value="{{old('firstName')}}">
    </div>

    <div class="form-group">
        <label>Etternavn*</label>
        <input type="text" name="lastName" id="lastName" value="{{old('lastName')}}">
    </div>

    <div class="form-group">
        <label>Epost*</label>
        <input type="text" name="email" id="email" value="{{old('email')}}">
    </div>

    <div class="form-group">
        <label>Telefon*</label>
        <input type="text" name="phone" id="phone" value="{{old('phone')}}">
    </div>

    <div class="form-group">
        <label>Hotell*</label>
        <select name="hotel" id="hotel">
            <option value="default">Velg hotell</option>
            @foreach ($hotels as $hotel)
                <option value="{{$hotel->hotelId}}">{{$hotel->name}}</option>
            @endforeach
    </select>
    </div>

    <div class="form-group">
        <label>Antall rom*</label>
        <input type="number" name="numRooms" id="numRooms" min="1" value="{{old('numRooms')}}">
    </div>

    <div class="form-group">
        <label>Fra*</label>
        <input type="date" name="fromDate" id="fromDate" value="{{old('fromDate')}}"">
    </div>

    <div class="form-group">
        <label>Til*</label>
        <input type="date" name="toDate" id="toDate" value="{{old('toDate')}}"">
    </div>

    <button type="submit" value="submit">Reserver</button> @if ($errors->any())
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
