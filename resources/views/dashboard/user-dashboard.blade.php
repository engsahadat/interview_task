@extends('layouts.app')
@section('title','User Dashboard')
@section('content')
    <div class="m-5">
        <h1>{{ __('User Dashboard') }}</h1>
        <p>{{ __('Welcome') }}, {{ Auth::user()->name }}</p>
    </div>
@endsection