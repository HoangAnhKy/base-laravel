@extends('Layout.error_web_layout')

@section('title', '404 - Page Not Found')

@section('content')
    <h1 style="color: #ff6b6b;">404</h1>
    <p>Oops! The page you are looking for does not exist.</p>
    <a href="{{ url('/') }}">Go Back to Home</a>
@endsection
