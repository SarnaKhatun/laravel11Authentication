@extends('layouts.layout')
@section('title', 'Admin Dashboard Page')
@section('content')
    <h2>Hi "{{\Illuminate\Support\Facades\Auth::user()->name ?? ''}}", Welcome to the Admin Dashboard</h2>
    <p>This is the body content of your dashboard. You can add your own content here.</p>
@endsection
