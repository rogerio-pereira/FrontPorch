@extends('errors.layout')

@section('title', 'Temporarily unavailable')
@section('status', 'Unavailable')
@section('code', '503')
@section('heading', 'We will be right back')
@section('message', 'The porch is briefly closed for care and updates. Please check again soon — we appreciate your patience.')

@section('actions')
    <a href="{{ url('/') }}" class="btn btn-primary" data-test="error-home">
        Try home again
    </a>
@endsection
