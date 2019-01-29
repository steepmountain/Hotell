@extends('layouts.app')
@section('content')
<h1>Suksess!</h1>

<h2>{{$hotel}}</h2>
@foreach ($reservations as $reservation)
<ul style="list-style: none; margin: 0 0 15px 0; padding: 0;">
    <li>Rom nr: {{$reservation->roomId}}</li>
    <li>Fra: {{$reservation->fromDate}}</li>
    <li>Til: {{$reservation->toDate}}</li>
</ul>
@endforeach
<p>Totalt kr {{$price}},-</p>
</form>
@endsection
