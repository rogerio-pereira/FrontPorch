@extends('errors.layout')

@section('title', 'Page not found')
@section('status', 'Not found')
@section('code', '404')
@section('heading', 'This page is not on the porch')
@section('message', 'The page you asked for is missing or may have moved. Head home and we will help you find the right next step.')

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary" data-test="error-home">
        Back to home
    </a>
    <a href="{{ url('/#contact') }}" class="btn btn-secondary" data-test="error-contact">
        Contact us
    </a>
@endsection
