<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Notificaciones') }}
            </h2>
            <a href="{{ route('notifications.create') }}"
               class="inline-flex items-center px-4 py-2 bg-white text-primary hover:bg-gray-50 rounded-md transition-colors font-semibold text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nueva Notificación
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg divide-y divide-gray-200">
                @forelse($notifications as $notification)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start space-x-4">
                            @if($notification->type->icon)
                                <div class="flex-shrink-0 text-2xl">
                                    {{ $notification->type->icon }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $notification->title }}
                                    </h3>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('notifications.preview', $notification) }}"
                                           class="inline-flex items-center px-3 py-1 bg-primary text-white text-sm rounded-md hover:bg-primary-dark transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Previsualizar
                                        </a>
                                        <form action="{{ route('notifications.sendNow', $notification) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-accent text-white text-sm rounded-md hover:bg-accent-dark transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Enviar Ahora
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                                    {{ $notification->content }}
                                </p>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                            style="background-color: {{ $notification->type->color }}20; color: {{ $notification->type->color }}">
                                            {{ $notification->type->name }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                        @if($notification->scheduled_for)
                                            <span class="flex items-center text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Programada: {{ $notification->scheduled_for->format('d/m/Y H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if(!$notification->read_at)
                                            <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-sm text-accent hover:text-secondary transition-colors">
                                                    Marcar como leída
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(!$notification->read_at)
                                <div class="flex-shrink-0">
                                    <span class="inline-block w-2 h-2 bg-accent rounded-full animate-pulse"></span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay notificaciones</h3>
                        <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva notificación.</p>
                        <div class="mt-6">
                            <a href="{{ route('notifications.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nueva Notificación
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
