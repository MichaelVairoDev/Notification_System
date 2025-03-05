<div class="relative" x-data="{ open: @entangle('showDropdown') }">
    <button @click="$wire.toggleDropdown()"
        class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-primary hover:text-secondary focus:outline-none transition-colors">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-accent rounded-full animate-pulse">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-96 rounded-lg shadow-fancy bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 divide-y divide-gray-100"
        style="display: none;">

        <!-- Header del Dropdown -->
        <div class="px-4 py-3 bg-gradient-to-r from-primary to-secondary rounded-t-lg">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-white">Notificaciones Recientes</h3>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead"
                        class="text-xs text-white hover:text-gray-200 transition-colors">
                        Marcar todas como leídas
                    </button>
                @endif
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-gray-50 px-4 py-2 flex space-x-2 text-sm">
            <button wire:click="setFilter('all')"
                class="px-3 py-1 rounded-full {{ $filter === 'all' ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-200' }} transition-colors">
                Todas
            </button>
            <button wire:click="setFilter('unread')"
                class="px-3 py-1 rounded-full {{ $filter === 'unread' ? 'bg-accent text-white' : 'text-gray-600 hover:bg-gray-200' }} transition-colors">
                No leídas
                @if($unreadCount > 0)
                    <span class="ml-1 bg-white bg-opacity-20 px-1.5 rounded-full text-xs">
                        {{ $unreadCount }}
                    </span>
                @endif
            </button>
            <button wire:click="setFilter('read')"
                class="px-3 py-1 rounded-full {{ $filter === 'read' ? 'bg-success text-white' : 'text-gray-600 hover:bg-gray-200' }} transition-colors">
                Leídas
            </button>
        </div>

        <!-- Lista de Notificaciones -->
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 hover:bg-gray-50 {{ !$notification->read_at ? 'bg-gray-50' : '' }} transition-colors">
                    <div class="flex items-start space-x-3">
                        @if($notification->type->icon)
                            <div class="flex-shrink-0 text-2xl">
                                {{ $notification->type->icon }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('notifications.show', $notification) }}"
                                   class="text-sm font-medium text-primary hover:text-secondary">
                                    {{ $notification->title }}
                                </a>
                                @if(!$notification->read_at)
                                    <button wire:click="markAsRead({{ $notification->id }})"
                                        class="text-xs text-accent hover:text-secondary transition-colors">
                                        Marcar como leída
                                    </button>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-gray-500 line-clamp-2">
                                {{ $notification->content }}
                            </p>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                    style="background-color: {{ $notification->type->color }}20; color: {{ $notification->type->color }}">
                                    {{ $notification->type->name }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
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
                <div class="px-4 py-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    @if($filter === 'all')
                        <p class="mt-2 text-sm font-medium text-gray-900">No hay notificaciones</p>
                        <p class="mt-1 text-sm text-gray-500">Las notificaciones aparecerán aquí.</p>
                    @elseif($filter === 'unread')
                        <p class="mt-2 text-sm font-medium text-gray-900">No hay notificaciones sin leer</p>
                        <p class="mt-1 text-sm text-gray-500">¡Estás al día!</p>
                    @else
                        <p class="mt-2 text-sm font-medium text-gray-900">No hay notificaciones leídas</p>
                        <p class="mt-1 text-sm text-gray-500">Las notificaciones que marques como leídas aparecerán aquí.</p>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Footer del Dropdown -->
        <div class="px-4 py-3 bg-gray-50 rounded-b-lg flex justify-between items-center">
            <a href="{{ route('notifications.index') }}"
                class="text-sm text-secondary hover:text-primary transition-colors font-medium">
                Ver todas las notificaciones
            </a>
            @if(count($notifications) > 0)
                <span class="text-xs text-gray-500">
                    Mostrando {{ count($notifications) }} de {{ $totalNotifications ?? 'muchas' }}
                </span>
            @endif
        </div>
    </div>
</div>
