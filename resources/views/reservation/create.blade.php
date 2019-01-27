@extends('layouts.app')
@section('content')
<h1>Reservasjon</h1>
<form>
    @csrf

    <input type="text" name="firstName" id="firstName">
    <input type="text" name="lastName" id="lastName">
    <input type="text" name="email" id="email">
    <input type="text" name="phone" id="phone">

    <select name="city">
        <option>Velg by</option>
        @foreach ($cities as $city)
            <option value="{{$city->city}}">{{$city->city}}</option>
        @endforeach
    </select>

    <input type="number" name="numRooms" id="numRooms">
    <input type="date" name="fromDate" id="fromDate">
    <input type="date" name="toDate" id="toDate">
</form>
@endsection
