<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crear Notificación') }}
            </h2>
            <a href="{{ route('notifications.index') }}" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-secondary text-white rounded-md transition-colors">
                Volver al Listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('notifications.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <!-- Tipo de Notificación -->
                            <div>
                                <label for="notification_type_id" class="block text-sm font-medium text-gray-700">
                                    Tipo de Notificación
                                </label>
                                <select name="notification_type_id" id="notification_type_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                    <option value="">Selecciona un tipo</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('notification_type_id') == $type->id ? 'selected' : '' }}
                                            data-color="{{ $type->color }}"
                                            data-icon="{{ $type->icon }}">
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('notification_type_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Título -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">
                                    Título
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contenido -->
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700">
                                    Contenido
                                </label>
                                <textarea name="content" id="content" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Programación -->
                            <div>
                                <label for="scheduled_for" class="block text-sm font-medium text-gray-700">
                                    Programar para (opcional)
                                </label>
                                <input type="datetime-local" name="scheduled_for" id="scheduled_for"
                                    value="{{ old('scheduled_for') }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent focus:ring-accent">
                                @error('scheduled_for')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Vista Previa -->
                            <div x-data="{
                                type: null,
                                updatePreview() {
                                    const select = document.getElementById('notification_type_id');
                                    const option = select.options[select.selectedIndex];
                                    this.type = {
                                        color: option.dataset.color || '#000000',
                                        icon: option.dataset.icon || ''
                                    };
                                }
                            }" x-init="updatePreview()" @change="updatePreview()">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Vista Previa</h3>
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <div class="flex items-start space-x-4">
                                        <template x-if="type?.icon">
                                            <div class="flex-shrink-0 text-2xl" x-text="type.icon"></div>
                                        </template>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                <span x-text="document.getElementById('title').value || 'Título de la notificación'"></span>
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500">
                                                <span x-text="document.getElementById('content').value || 'Contenido de la notificación'"></span>
                                            </p>
                                            <div class="mt-2">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                    :style="`background-color: ${type?.color}20; color: ${type?.color}`">
                                                    <span x-text="document.getElementById('notification_type_id').options[document.getElementById('notification_type_id').selectedIndex].text"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('notifications.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent">
                                    Crear Notificación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
