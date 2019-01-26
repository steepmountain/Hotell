@extends('layouts.app')
@section('content')
<h1>Reservasjon</h1>
<form>
    <input type="text" name="firstName" id="firstName">
    <input type="text" name="lastName" id="lastName">
    <input type="text" name="email" id="email">
    <input type="text" name="phone" id="phone">
    <select>
        <option>Choose one</option>
    </select>
    <input type="number" name="numRooms" id="numRooms">
    <input type="date" name="fromDate" id="fromDate">
    <input type="date" name="toDate" id="toDate">
</form>
@endsection
