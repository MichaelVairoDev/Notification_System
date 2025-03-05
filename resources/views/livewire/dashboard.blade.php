<div class="space-y-6" wire:poll.{{ $pollingInterval }}ms="refreshStatistics">
    <!-- Estadísticas Generales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary/10 text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Total Notificaciones</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $totalNotifications }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-accent/10 text-accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">No Leídas</h2>
                    <p class="text-2xl font-semibold text-gray-700">{{ $unreadNotifications }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm col-span-2">
            <h2 class="text-gray-600 text-sm mb-4">Tendencia Últimos 7 Días</h2>
            <div wire:ignore id="trendChart" style="height: 100px;"></div>
        </div>
    </div>

    <!-- Gráficos y Estadísticas Detalladas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Distribución por Tipo -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Distribución por Tipo</h2>
            <div wire:ignore id="typeDistributionChart" style="height: 300px;"></div>
        </div>

        <!-- Notificaciones Recientes -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Notificaciones Recientes</h2>
            <div class="space-y-4">
                @foreach($recentNotifications as $notification)
                    <div class="flex items-start space-x-4 p-3 {{ !$notification->read_at ? 'bg-gray-50' : '' }} rounded-lg">
                        @if($notification->type->icon)
                            <span class="text-xl">{{ $notification->type->icon }}</span>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $notification->title }}
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                {{ Str::limit($notification->content, 50) }}
                            </p>
                            <div class="mt-1 flex items-center space-x-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                    style="background-color: {{ $notification->type->color }}20; color: {{ $notification->type->color }}">
                                    {{ $notification->type->name }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        @if(!$notification->read_at)
                            <div class="flex-shrink-0">
                                <span class="inline-block w-2 h-2 bg-accent rounded-full"></span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        const trendData = @json($notificationTrend);
        const typeData = @json($notificationsByType);

        // Gráfico de tendencia
        const trendOptions = {
            series: [{
                name: 'Notificaciones',
                data: trendData.map(item => item.count)
            }],
            chart: {
                type: 'area',
                height: 100,
                sparkline: {
                    enabled: true
                },
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3
                }
            },
            colors: ['#27445D']
        };

        const trendChart = new ApexCharts(document.querySelector("#trendChart"), trendOptions);
        trendChart.render();

        // Gráfico de distribución por tipo
        const typeOptions = {
            series: typeData.map(type => type.count),
            chart: {
                type: 'donut',
                height: 300
            },
            labels: typeData.map(type => type.name),
            colors: typeData.map(type => type.color),
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            }
        };

        const typeChart = new ApexCharts(document.querySelector("#typeDistributionChart"), typeOptions);
        typeChart.render();

        // Actualizar gráficos cuando cambien los datos
        Livewire.on('statisticsUpdated', (data) => {
            trendChart.updateSeries([{
                data: data.trend.map(item => item.count)
            }]);

            typeChart.updateSeries(data.byType.map(type => type.count));
            typeChart.updateOptions({
                labels: data.byType.map(type => type.name),
                colors: data.byType.map(type => type.color)
            });
        });
    });
</script>
@endpush
