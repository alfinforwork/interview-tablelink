@php
    $user = auth()->user();
    $isAdmin = $user->isAdmin();

    $menuItems = $isAdmin ? [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'User Management', 'route' => 'users.index', 'icon' => 'users'],
        ['label' => 'Flight Information', 'route' => 'flights.index', 'icon' => 'plane'],
    ] : [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'home'],
    ];
@endphp

<aside class="w-64 bg-gray-900 text-white min-h-screen fixed left-0 top-0">
    <div class="p-6 border-b border-gray-800">
        <h1 class="text-xl font-semibold">TableLink</h1>
        <p class="text-sm text-gray-400 mt-1">{{ $user->isAdmin() ? 'Admin' : 'User' }} Panel</p>
    </div>

    <nav class="mt-8">
        @foreach ($menuItems as $item)
            <a href="{{ route($item['route']) }}"
                class="block px-6 py-3 text-gray-300 hover:bg-gray-800 hover:text-white transition {{ request()->routeIs($item['route']) ? 'bg-indigo-600 text-white' : '' }}">
                <span class="flex items-center gap-3">
                    @switch($item['icon'])
                        @case('home')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4m-7 4v10m-7-4v4m14-4v4" />
                            </svg>
                        @break
                        @case('users')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm6-12h-3m0 0h-3m3 0v3m0-3v-3m0 3h3" />
                            </svg>
                        @break
                        @case('plane')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        @break
                    @endswitch
                    {{ $item['label'] }}
                </span>
            </a>
        @endforeach
    </nav>

    <div class="absolute bottom-0 left-0 right-0 border-t border-gray-800 p-6">
        <div class="text-sm text-gray-400 mb-4">
            <p class="font-medium text-white">{{ $user->name }}</p>
            <p>{{ $user->email }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white transition rounded">
                Logout
            </button>
        </form>
    </div>
</aside>
