@extends('errors.layout')

@section('title', 'Something went sideways')
@section('status', 'Hiccup')
@section('code', '500')
@section('heading', 'Something went sideways on the porch')
@section('message', 'Give it a moment and try again. If it keeps happening, say hello — we will help you get back on track.')

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary" data-test="error-home">
        Back to home
    </a>
    <a href="{{ url('/#contact') }}" class="btn btn-secondary" data-test="error-contact">
        Contact us
    </a>
@endsection
