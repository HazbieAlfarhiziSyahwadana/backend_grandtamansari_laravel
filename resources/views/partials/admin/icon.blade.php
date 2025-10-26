@php($icon = $icon ?? 'squares')

@switch($icon)
    @case('squares')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H5.25A1.5 1.5 0 0 0 3.75 5.25V9a1.5 1.5 0 0 0 1.5 1.5H9A1.5 1.5 0 0 0 10.5 9V5.25a1.5 1.5 0 0 0-1.5-1.5ZM18.75 3.75H15a1.5 1.5 0 0 0-1.5 1.5V9a1.5 1.5 0 0 0 1.5 1.5h3.75A1.5 1.5 0 0 0 21 9V5.25a1.5 1.5 0 0 0-1.5-1.5ZM9 13.5H5.25a1.5 1.5 0 0 0-1.5 1.5v3.75a1.5 1.5 0 0 0 1.5 1.5H9a1.5 1.5 0 0 0 1.5-1.5V15a1.5 1.5 0 0 0-1.5-1.5ZM18.75 13.5H15a1.5 1.5 0 0 0-1.5 1.5v3.75a1.5 1.5 0 0 0 1.5 1.5h3.75a1.5 1.5 0 0 0 1.5-1.5V15a1.5 1.5 0 0 0-1.5-1.5Z" />
        </svg>
        @break

    @case('document')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v6l3-1.5m3-3.75v12.75a1.875 1.875 0 0 1-1.875 1.875h-10.5A1.875 1.875 0 0 1 3.75 18.75V5.25A1.875 1.875 0 0 1 5.625 3.375h10.5A1.875 1.875 0 0 1 18 5.25Z" />
        </svg>
        @break

    @case('tag')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75h4.379a1.5 1.5 0 0 1 1.06.44l6.871 6.871a1.5 1.5 0 0 1 0 2.121l-4.379 4.379a1.5 1.5 0 0 1-2.121 0L6.44 11.81a1.5 1.5 0 0 1-.44-1.06V6a2.25 2.25 0 0 1 2.25-2.25Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 7.5h.007v.007H9.75V7.5Z" />
        </svg>
        @break

    @case('home')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 4l9 6.5M4.5 10.5v7.875A1.125 1.125 0 0 0 5.625 19.5h2.25A1.125 1.125 0 0 0 9 18.375V15.75a1.125 1.125 0 0 1 1.125-1.125h3.75A1.125 1.125 0 0 1 15 15.75v2.625a1.125 1.125 0 0 0 1.125 1.125h2.25A1.125 1.125 0 0 0 19.5 18.375V10.5" />
        </svg>
        @break

    @case('chart')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 3.264-3.264a1.5 1.5 0 0 1 2.122 0l2.128 2.129m1.536-1.536 2.15-2.15a1.5 1.5 0 0 1 2.122 0L20.25 12" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18A2.25 2.25 0 0 0 4.5 20.25h15A2.25 2.25 0 0 0 21.75 18V6A2.25 2.25 0 0 0 19.5 3.75h-15A2.25 2.25 0 0 0 2.25 6v12Z" />
        </svg>
        @break

    @case('photo')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75A2.25 2.25 0 0 1 5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75v10.5A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25V6.75Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="m7.5 14.25 2.621-2.621a1.125 1.125 0 0 1 1.589 0l3.789 3.789M14.25 9.75h.007v.007h-.007V9.75Z" />
        </svg>
        @break

    @case('sparkles')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75h.008v.008H9V6.75Zm-2.25 7.5h.008v.008H6.75v-.008ZM12 3l1.2 3.6L16.8 7.8 13.5 10.2 14.7 13.8 12 11.7 9.3 13.8 10.5 10.2 7.2 7.8l3.6-1.2L12 3ZM6 18l.6 1.8L8.4 20.4 7.05 21.45 7.65 23.25 6 22.2 4.35 23.25 4.95 21.45 3.6 20.4l1.8-.6L6 18Zm12-3 1.05 3.15L21 19.5l-2.4 1.8.9 2.7L18 21.6l-1.5 2.1.9-2.7L15 19.5l1.95-.75L18 15Z" />
        </svg>
        @break

    @case('shield')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4.5 6v6c0 5.25 3.75 9.75 7.5 10.5 3.75-.75 7.5-5.25 7.5-10.5V6L12 3Z" />
        </svg>
        @break

    @case('link')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m13.5 8.25 2.25-2.25a3 3 0 0 1 4.243 4.243l-3 3a3 3 0 0 1-4.243 0l-.257-.257" />
            <path stroke-linecap="round" stroke-linejoin="round" d="m10.5 15.75-2.25 2.25a3 3 0 1 1-4.243-4.243l3-3a3 3 0 0 1 4.243 0l.257.257" />
        </svg>
        @break

    @case('users')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM4.5 18.75a4.5 4.5 0 0 1 9 0v.75a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75v-.75ZM15.75 9a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM18 14.25a4.5 4.5 0 0 1 4.5 4.5v.75a.75.75 0 0 1-.75.75h-3.75" />
        </svg>
        @break

    @default
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75A2.25 2.25 0 0 1 6.75 4.5h10.5A2.25 2.25 0 0 1 19.5 6.75v10.5A2.25 2.25 0 0 1 17.25 19.5H6.75A2.25 2.25 0 0 1 4.5 17.25V6.75Z" />
        </svg>
        @break
@endswitch
