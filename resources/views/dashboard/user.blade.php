@extends('layouts.dashboard')

@section('title', 'User Dashboard')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Welcome, {{ auth()->user()->name }}!</h2>
        <p class="text-gray-600">This is your personal dashboard.</p>
    </div>
@endsection
