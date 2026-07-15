@extends('layouts.dashboard')

@section('content')

<div class="p-4">

<h1 class="text-2xl font-bold">

Dashboard Manager

</h1>

<p>

Selamat datang {{ auth()->user()->name }}

</p>

</div>

@endsection
