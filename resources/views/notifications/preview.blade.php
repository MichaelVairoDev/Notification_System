<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                Vista Previa de Notificación
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        @if($notification->type->icon)
                            <div class="flex-shrink-0 text-4xl">
                                {{ $notification->type->icon }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <div class="border-b pb-4 mb-4">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                    {{ $notification->title }}
                                </h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full"
                                        style="background-color: {{ $notification->type->color }}20; color: {{ $notification->type->color }}">
                                        {{ $notification->type->name }}
                                    </span>
                                    <span>{{ $notification->created_at->format('d/m/Y H:i') }}</span>
                                    @if($notification->scheduled_for)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Programada para: {{ $notification->scheduled_for->format('d/m/Y H:i') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="prose max-w-none">
                                {{ $notification->content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <form action="{{ route('notifications.sendNow', $notification) }}" method="POST" class="inline">
                    @csrf
                    <x-button type="submit" class="bg-accent hover:bg-accent-dark focus:ring-accent">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enviar Ahora
                    </x-button>
                </form>

                <x-button type="button" onclick="window.location.href='{{ route('notifications.index') }}'"
                    class="bg-gray-600 hover:bg-gray-500 focus:ring-gray-500">
                    Volver a Notificaciones
                </x-button>
            </div>
        </div>
    </div>
</x-app-layout>
