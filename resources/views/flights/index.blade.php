@extends('layouts.dashboard')

@section('title', 'Flight Information')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Flight Information</h2>
                    <p class="text-sm text-gray-500 mt-1">Jakarta (CGK) → Bali (DPS) • Economy • One-way • Before 5:00 PM</p>
                </div>
                <div class="flex gap-3">
                    <button id="fetchBtn" type="button"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg id="fetchIcon" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <svg id="fetchSpinner" class="hidden animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span id="fetchBtnText">Fetch from Tiket.com</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Alert Container -->
        <div id="alertContainer" class="hidden px-6 pt-4">
            <div id="alertMessage" class="flex items-start p-4 rounded-lg bg-green-50 text-green-800">
                <svg id="alertIcon" class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-green-400" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <p id="alertText"></p>
                    <p id="alertNote" class="hidden mt-2 text-sm opacity-75"></p>
                </div>
            </div>
        </div>

        <!-- Flight Count -->
        <div id="flightCount" class="hidden px-6 pt-4">
            <p class="text-sm text-gray-600">
                Showing <span id="flightCountNumber" class="font-semibold text-gray-800">0</span> flights
            </p>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Airline
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Flight
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departure
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                        </th>
                    </tr>
                </thead>
                <tbody id="flightsTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Flight data will be inserted here -->
                </tbody>
            </table>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No flights loaded</h3>
                <p class="mt-2 text-sm text-gray-500">Click "Fetch from Tiket.com" to view flight information.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fetchBtn = document.getElementById('fetchBtn');
            const fetchSpinner = document.getElementById('fetchSpinner');
            const fetchIcon = document.getElementById('fetchIcon');
            const fetchBtnText = document.getElementById('fetchBtnText');
            const tableBody = document.getElementById('flightsTableBody');
            const emptyState = document.getElementById('emptyState');
            const alertContainer = document.getElementById('alertContainer');
            const alertMessage = document.getElementById('alertMessage');
            const alertIcon = document.getElementById('alertIcon');
            const alertText = document.getElementById('alertText');
            const alertNote = document.getElementById('alertNote');
            const flightCount = document.getElementById('flightCount');
            const flightCountNumber = document.getElementById('flightCountNumber');

            function showAlert(message, type = 'success', note = null) {
                alertContainer.classList.remove('hidden');

                if (type === 'success') {
                    alertMessage.className = 'flex items-start p-4 rounded-lg bg-green-50 text-green-800';
                    alertIcon.innerHTML =
                        '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
                    alertIcon.className = 'w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-green-400';
                } else if (type === 'warning') {
                    alertMessage.className = 'flex items-start p-4 rounded-lg bg-amber-50 text-amber-800';
                    alertIcon.innerHTML =
                        '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>';
                    alertIcon.className = 'w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-amber-400';
                } else {
                    alertMessage.className = 'flex items-start p-4 rounded-lg bg-red-50 text-red-800';
                    alertIcon.innerHTML =
                        '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
                    alertIcon.className = 'w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-red-400';
                }

                alertText.textContent = message;

                if (note) {
                    alertNote.textContent = note;
                    alertNote.classList.remove('hidden');
                } else {
                    alertNote.classList.add('hidden');
                }

                const timeout = note ? 15000 : (type === 'success' ? 5000 : 8000);
                setTimeout(() => {
                    alertContainer.classList.add('hidden');
                }, timeout);
            }

            function setLoading(loading) {
                fetchBtn.disabled = loading;
                fetchSpinner.classList.toggle('hidden', !loading);
                fetchIcon.classList.toggle('hidden', loading);
                fetchBtnText.textContent = loading ? 'Fetching...' : 'Fetch from Tiket.com';
            }

            function renderFlights(flights) {
                tableBody.innerHTML = '';

                if (flights.length === 0) {
                    emptyState.classList.remove('hidden');
                    flightCount.classList.add('hidden');
                    return;
                }

                emptyState.classList.add('hidden');
                flightCount.classList.remove('hidden');
                flightCountNumber.textContent = flights.length;

                flights.forEach(flight => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-50 transition-colors';
                    row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${flight.airline}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            ${flight.flight_number}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 font-medium">${flight.departure_time}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="font-medium text-gray-900">${flight.departure_airport}</span>
                            <svg class="mx-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                            <span class="font-medium text-gray-900">${flight.arrival_airport}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <div class="text-sm font-semibold text-gray-900">${flight.price}</div>
                    </td>
                `;
                    tableBody.appendChild(row);
                });
            }

            async function fetchFlights() {
                setLoading(true);

                try {
                    const response = await fetch('{{ route('flights.fetch') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        renderFlights(data.data);
                        if (data.data.length > 0) {
                            showAlert('Successfully loaded ' + data.data.length + ' flights!', 'success');
                        } else {
                            showAlert(data.message || 'No flights found matching the criteria', 'warning', data
                                .note || null);
                        }
                    } else {
                        renderFlights([]);
                        showAlert(data.message || 'Failed to fetch flights', 'error', data.note || null);
                    }
                } catch (error) {
                    console.error('Error fetching flights:', error);
                    showAlert('An error occurred while fetching flights. Please try again.', 'error');
                    renderFlights([]);
                } finally {
                    setLoading(false);
                }
            }

            fetchBtn.addEventListener('click', fetchFlights);
        });
    </script>
@endpush
