@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Welcome, Admin!</h2>
            <p class="text-gray-600">You have access to all administrative features.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-2">User Management</h3>
                <p class="text-sm text-gray-600 mb-4">Manage all users in the system</p>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    View Users →
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Flight Information</h3>
                <p class="text-sm text-gray-600 mb-4">View flight data from Tiket.com</p>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    View Flights →
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-2">Charts</h3>
                <p class="text-sm text-gray-600 mb-4">View analytics and reports</p>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                    View Charts →
                </a>
            </div>
        </div>
    </div>
@endsection
