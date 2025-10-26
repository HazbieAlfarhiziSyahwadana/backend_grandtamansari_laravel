@props([
    'field',
    'current' => null,
    'direction' => 'asc',
])

@php
    $isActive = $current === $field;
@endphp

<span {{ $attributes->class('inline-flex w-3 h-3 items-center justify-center') }}>
    @if ($isActive)
        @if ($direction === 'asc')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .53.22l5 5a.75.75 0 1 1-1.06 1.06L10 4.81 5.53 9.28a.75.75 0 1 1-1.06-1.06l5-5A.75.75 0 0 1 10 3Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M10 3.75a.75.75 0 0 1 .75.75v12a.75.75 0 0 1-1.5 0v-12A.75.75 0 0 1 10 3.75Z" clip-rule="evenodd" />
            </svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3">
                <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.53-.22l-5-5a.75.75 0 1 1 1.06-1.06L10 15.19l4.47-4.47a.75.75 0 1 1 1.06 1.06l-5 5A.75.75 0 0 1 10 17Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M10 16.25a.75.75 0 0 1-.75-.75v-12a.75.75 0 0 1 1.5 0v12a.75.75 0 0 1-.75.75Z" clip-rule="evenodd" />
            </svg>
        @endif
    @else
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3 opacity-40">
            <path fill-rule="evenodd" d="M9.25 4a.75.75 0 0 1 1.5 0v12a.75.75 0 0 1-1.5 0V4Zm-3.5 3a.75.75 0 0 1 .75-.75h8a.75.75 0 0 1 0 1.5h-8A.75.75 0 0 1 5.75 7Zm0 6a.75.75 0 0 1 .75-.75h8a.75.75 0 0 1 0 1.5h-8A.75.75 0 0 1 5.75 13Z" clip-rule="evenodd" />
        </svg>
    @endif
</span>
