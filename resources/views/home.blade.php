@extends('layouts.master')

@section('content')

<div class="container">

    <h1>A Simple Twitter Client</h1>

    <form action="{{ route('logout') }}" method="POST">
    	{{ csrf_field() }}
    	<button class="nav-link" type="submit">Logout</button>
  	</form>

</div>

@endsection
