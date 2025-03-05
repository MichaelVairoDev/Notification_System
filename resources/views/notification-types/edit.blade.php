<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Tipo de Notificación') }}
            </h2>
            <a href="{{ route('notification-types.index') }}" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-secondary text-white font-semibold rounded-md">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('notification-types.update', $notificationType) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nombre
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $notificationType->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">
                                    Descripción
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">{{ old('description', $notificationType->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="icon" class="block text-sm font-medium text-gray-700">
                                    Icono (opcional)
                                </label>
                                <x-emoji-picker
                                    name="icon"
                                    id="icon"
                                    value="{{ old('icon', $notificationType->icon) }}" />
                                @error('icon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700">
                                    Color
                                </label>
                                <div class="mt-1 flex items-center">
                                    <input type="color" name="color" id="color" value="{{ old('color', $notificationType->color) }}"
                                        class="h-10 w-20 rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                    <span class="ml-2 text-sm text-gray-500">Selecciona un color para identificar este tipo de notificación</span>
                                </div>
                                @error('color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('notification-types.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                                    Actualizar Tipo de Notificación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
