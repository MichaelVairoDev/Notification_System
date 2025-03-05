<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $notification->title }}
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
                    <div class="mb-8">
                        <div class="flex items-center space-x-4">
                            @if($notification->type->icon)
                                <div class="flex-shrink-0 text-3xl">
                                    {{ $notification->type->icon }}
                                </div>
                            @endif
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium"
                                    style="background-color: {{ $notification->type->color }}20; color: {{ $notification->type->color }}">
                                    {{ $notification->type->name }}
                                </span>
                                <div class="mt-1 text-sm text-gray-500">
                                    {{ $notification->created_at->format('d/m/Y H:i') }}
                                    @if($notification->scheduled_for)
                                        · Programada para: {{ $notification->scheduled_for->format('d/m/Y H:i') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        {!! nl2br(e($notification->content)) !!}
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            @if($notification->read_at)
                                Leída {{ $notification->read_at->diffForHumans() }}
                            @else
                                <span class="text-accent">No leída</span>
                            @endif
                        </div>

                        <div class="flex space-x-4">
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-accent text-white rounded-md hover:bg-secondary transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Marcar como leída
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta notificación?')"
                                    class="inline-flex items-center px-4 py-2 border border-red-300 text-red-700 hover:bg-red-50 rounded-md transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
