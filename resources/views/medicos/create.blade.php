<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Alta de Médico
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('medicos.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700">Nombre</label>
                            <input type="text" name="nombre" required class="mt-1 block w-full" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Apellido</label>
                            <input type="text" name="apellido" required class="mt-1 block w-full" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Especialidad</label>
                            <input type="text" name="especialidad" required class="mt-1 block w-full" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Correo electrónico</label>
                            <input type="email" name="email" required class="mt-1 block w-full" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700">Contraseña</label>
                            <input type="password" name="password" required class="mt-1 block w-full" />
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
