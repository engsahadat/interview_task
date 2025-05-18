@extends('layouts.app')
@section('title','Admin Dashboard')
@section('content')
    <div class="m-5">
        <h1>{{ __('Admin Dashboard') }}</h1>
        <p>{{ __('Welcome') }}, {{ Auth::user()->name }}</p>
    </div>
@endsection