@props(['state' => 'idle', 'message' => ''])

@php
$states = [
    'idle' => [
        'icon' => null,
        'text' => 'text-gray-500',
        'bg' => 'bg-gray-50',
    ],
    'loading' => [
        'text' => 'text-primary',
        'bg' => 'bg-primary/10',
    ],
    'success' => [
        'icon' => '
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        ',
        'text' => 'text-green-700',
        'bg' => 'bg-green-50',
    ],
    'error' => [
        'icon' => '
            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        ',
        'text' => 'text-red-700',
        'bg' => 'bg-red-50',
    ],
];

$currentState = $states[$state] ?? $states['idle'];
@endphp

<div class="rounded-md p-4 {{ $currentState['bg'] }}">
    <div class="flex">
        @if($state === 'loading')
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($currentState['icon'])
            <div class="flex-shrink-0">
                {!! $currentState['icon'] !!}
            </div>
        @endif

        <div class="ml-3">
            <p class="text-sm font-medium {{ $currentState['text'] }}">
                {{ $message }}
            </p>
        </div>
    </div>
</div>
