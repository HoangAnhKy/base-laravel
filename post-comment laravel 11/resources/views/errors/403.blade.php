@extends('Layout.error_web_layout')

@section('title', '403 - Forbidden')

@section('content')
    <h1 style="color: #ffa502;">403</h1>
    <p>Sorry, you are not authorized to access this page.</p>
    <a href="{{ url('/') }}">Go Back to Home</a>
@endsection
