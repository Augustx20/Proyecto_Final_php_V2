<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-100 via-blue-300 to-blue-500 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-4">
                <a href="/" class="flex items-center gap-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/2965/2965567.png" alt="Logo" class="w-10 h-10">
                    <span class="text-2xl font-bold text-blue-700">Swiiss Médicos</span>
                </a>
                <div class="hidden sm:flex gap-4 ml-8">
                    <a href="{{ route('dashboard') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition">Dashboard</a>
                    <a href="{{ route('turnos.index') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition">Turnos</a>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a href="{{ route('medicos.index') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition">Gestión de Médicos</a>
                    @endif
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-4">
                <span class="text-blue-900 font-semibold">{{ Auth::user()->name ?? '' }}</span>
                @if(auth()->check() && auth()->user()->role === 'doctor')
                    @php
                        $medico = auth()->user()->medico;
                        $disponible = $medico?->disponible ?? false;
                    @endphp
                    <form method="POST" action="{{ route('doctor.toggle') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 hover:opacity-70 transition cursor-pointer">
                            <div class="w-4 h-4 rounded-full @if($disponible) bg-green-600 @else bg-red-600 @endif"></div>
                            <span class="text-sm font-semibold @if($disponible) text-green-600 @else text-red-600 @endif">
                                @if($disponible) Disponible @else No disponible @endif
                            </span>
                        </button>
                    </form>
                @endif
                <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline font-semibold">Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 hover:underline font-semibold">Salir</button>
                </form>
            </div>
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="p-2 rounded-md text-blue-900 hover:bg-blue-200 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white shadow-lg">
        <div class="flex flex-col gap-2 p-4">
            <a href="{{ route('dashboard') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition">Dashboard</a>
            <a href="{{ route('turnos.index') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition">Turnos</a>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('medicos.index') }}" class="text-blue-900 font-semibold hover:text-blue-700 transition">Gestión de Médicos</a>
            @endif
            @if(auth()->check() && auth()->user()->role === 'doctor')
                <div class="border-t pt-2 mt-2">
                    @php
                        $medico = auth()->user()->medico;
                        $disponible = $medico?->disponible ?? false;
                    @endphp
                    <form method="POST" action="{{ route('doctor.toggle') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 w-full hover:opacity-70 transition cursor-pointer">
                            <div class="w-4 h-4 rounded-full @if($disponible) bg-green-600 @else bg-red-600 @endif"></div>
                            <p class="text-sm font-semibold @if($disponible) text-green-600 @else text-red-600 @endif">
                                @if($disponible) Disponible @else No disponible @endif
                            </p>
                        </button>
                    </form>
                </div>
            @endif
            <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline font-semibold">Perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-600 hover:underline font-semibold">Salir</button>
            </form>
        </div>
    </div>
</nav>
