@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="font-semibold text-red-800 mb-2">Errores encontrados:</h3>
                <ul class="list-disc list-inside text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Registrar Nuevo Médico</h1>
                
                <form method="POST" action="{{ route('medicos.store') }}">
                    @csrf

                    <!-- Nombre -->
                    <div class="mb-6">
                        <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                        <input 
                            type="text" 
                            id="nombre"
                            name="nombre" 
                            placeholder="Ej: Juan"
                            value="{{ old('nombre') }}"
                            required 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('nombre') border-red-500 bg-red-50 @enderror" 
                        />
                        @error('nombre')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="mb-6">
                        <label for="apellido" class="block text-sm font-semibold text-gray-700 mb-2">Apellido</label>
                        <input 
                            type="text" 
                            id="apellido"
                            name="apellido" 
                            placeholder="Ej: García"
                            value="{{ old('apellido') }}"
                            required 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('apellido') border-red-500 bg-red-50 @enderror" 
                        />
                        @error('apellido')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Especialidad -->
                    <div class="mb-6">
                        <label for="especialidad" class="block text-sm font-semibold text-gray-700 mb-2">Especialidad</label>
                        <input 
                            type="text" 
                            id="especialidad"
                            name="especialidad" 
                            placeholder="Ej: Cardiología"
                            value="{{ old('especialidad') }}"
                            required 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('especialidad') border-red-500 bg-red-50 @enderror" 
                        />
                        @error('especialidad')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Correo electrónico -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            placeholder="Ej: doctor@hospital.com"
                            value="{{ old('email') }}"
                            required 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('email') border-red-500 bg-red-50 @enderror" 
                        />
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-8">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Contraseña</label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            placeholder="Mínimo 8 caracteres"
                            required 
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition @error('password') border-red-500 bg-red-50 @enderror" 
                        />
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4">
                        <button 
                            type="submit" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            Registrar Médico
                        </button>
                        <a 
                            href="{{ route('medicos.index') }}" 
                            class="flex-1 px-4 py-2 bg-gray-400 text-white font-semibold rounded-lg hover:bg-gray-500 transition text-center focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
