<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ auth()->user()?->role?->label() ?? 'Admin' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>[x-cloak]{display:none!important;}</style>
</head>
<body class="font-sans antialiased bg-slate-100">
    @php
        $companyProfile = \App\Models\Profile::first();
        $companyName = $companyProfile?->company ?? 'GTR Admin';
        $companyLogoUrl = $companyProfile?->logo ? asset('storage/'.$companyProfile->logo) : null;
        $roleLabel = auth()->user()?->role?->label();
        $links = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'ability' => 'manage-content', 'icon' => 'squares'],
            ['label' => 'Articles', 'route' => 'admin.articles.index', 'ability' => 'manage-content', 'icon' => 'document'],
            ['label' => 'Article Types', 'route' => 'admin.article-types.index', 'ability' => 'manage-content', 'icon' => 'tag'],
            ['label' => 'Unit Types', 'route' => 'admin.unit-types.index', 'ability' => 'manage-content', 'icon' => 'home'],
            ['label' => 'Commercial', 'route' => 'admin.commercials.index', 'ability' => 'manage-content', 'icon' => 'chart'],
            ['label' => 'Slideshow', 'route' => 'admin.slideshows.index', 'ability' => 'manage-content', 'icon' => 'photo'],
            ['label' => 'SEO', 'route' => 'admin.seo.index', 'ability' => 'manage-content', 'icon' => 'sparkles'],
            ['label' => 'Profile', 'route' => 'admin.profile.edit', 'ability' => 'manage-content', 'icon' => 'shield'],
            ['label' => 'Module Links', 'route' => 'admin.modules.index', 'ability' => 'manage-content', 'icon' => 'link'],
            ['label' => 'Users', 'route' => 'admin.users.index', 'ability' => 'manage-users', 'icon' => 'users'],
        ];
    @endphp
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">
        <div class="flex min-h-screen">
            <aside class="hidden w-72 flex-col bg-slate-950/95 px-5 py-6 text-slate-200 shadow-2xl ring-1 ring-slate-900/20 lg:flex">
                <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                    @if ($companyLogoUrl)
                        <img src="{{ $companyLogoUrl }}" alt="{{ $companyName }}" class="h-10 w-auto rounded-lg border border-white/10 bg-white/90 p-1">
                    @endif
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="text-base font-semibold text-white">{{ $companyName }}</a>
                        <p class="text-xs font-medium text-slate-400">{{ $roleLabel ?? 'Admin' }} Panel</p>
                    </div>
                </div>

                <div class="mt-8 flex-1 space-y-6">
                    <div>
                        <p class="px-2 text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">Navigasi</p>
                        <nav class="mt-3 space-y-1.5 text-sm font-medium">
                            @foreach ($links as $link)
                                @can($link['ability'])
                                    @php($isActive = request()->routeIs($link['route']))
                                    <a href="{{ route($link['route']) }}" class="group relative flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-150 {{ $isActive ? 'bg-white/15 text-white shadow-md shadow-slate-900/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-slate-300 transition group-hover:text-white {{ $isActive ? 'bg-white/20 text-white' : '' }}">
                                            @php($icon = $link['icon'])
                                            @include('partials.admin.icon', ['icon' => $icon])
                                        </span>
                                        <div class="flex flex-1 flex-col">
                                            <span>{{ $link['label'] }}</span>
                                            @if ($isActive)
                                                <span class="text-xs font-normal text-blue-200/80">Sedang dibuka</span>
                                            @endif
                                        </div>
                                        <span class="absolute inset-y-0 right-0 w-1 rounded-r-xl bg-gradient-to-b from-blue-400 to-blue-600 opacity-0 transition group-hover:opacity-100 {{ $isActive ? 'opacity-100' : '' }}"></span>
                                    </a>
                                @endcan
                            @endforeach
                        </nav>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-xs leading-relaxed text-slate-300">
                        <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">{{ $roleLabel ?? 'Admin' }}</p>
                        <p class="mt-3 text-[0.78rem]">Pantau aktivitas tim, kelola konten, dan pastikan pengalaman pengunjung selalu optimal.</p>
                    </div>
                </div>
            </aside>

            <div class="flex flex-1 flex-col">
                <header class="flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 shadow-sm">
                    <div class="flex items-center gap-3">
                        <button type="button" class="inline-flex items-center justify-center rounded-md border border-slate-200 p-2 text-slate-600 lg:hidden" @click="sidebarOpen = !sidebarOpen">
                            <span class="sr-only">Toggle sidebar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5m-16.5 6.75h16.5" />
                            </svg>
                        </button>
                        <h1 class="text-lg font-semibold text-slate-800">{{ $pageTitle ?? $roleLabel ?? 'Admin' }}</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden text-right text-xs sm:block">
                            <p class="font-semibold text-slate-700">{{ auth()->user()->name }}</p>
                            <p class="text-slate-400">{{ $roleLabel ?? 'Admin' }}</p>
                        </div>
                        <form x-data="{
                                open: false,
                                confirmLogout() {
                                    this.open = false;
                                    window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Anda berhasil keluar.', type: 'success', timeout: 2500 } }));
                                    const form = this.$refs.logoutForm ?? this.$el;
                                    if (form) {
                                        setTimeout(() => form.submit(), 320);
                                    }
                                }
                            }" x-ref="logoutForm" method="POST" action="{{ route('logout') }}" class="relative">
                            @csrf
                            <button type="button" @click="open = true" class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-3 py-1.5 text-sm font-semibold text-red-600 shadow-sm transition hover:border-red-300 hover:bg-red-50">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75H11V6a.75.75 0 0 1 1.28-.53l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5A.75.75 0 0 1 11 15v-3.25H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
                                </svg>
                                Keluar
                            </button>

                            <div x-cloak x-show="open" x-transition.opacity @click.away="open = false" @keydown.escape.window="open = false" class="absolute right-0 top-12 z-50 w-64 rounded-2xl border border-red-200 bg-white p-4 text-left shadow-xl">
                                <div class="flex items-start gap-3">
                                    <span class="rounded-full bg-red-100 p-2 text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-10.25a.75.75 0 0 0-1.5 0v3.5a.75.75 0 0 0 1.5 0v-3.5Zm0 5.5a.75.75 0 0 0-1.5 0v.75a.75.75 0 0 0 1.5 0v-.75Z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold text-slate-800">Konfirmasi keluar</p>
                                        <p class="text-xs text-slate-500">Anda akan keluar dari dashboard. Pastikan semua perubahan telah disimpan.</p>
                                        <div class="mt-3 flex items-center gap-2">
                                            <button type="button" @click="open = false" class="inline-flex items-center rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">Batal</button>
                                            <button type="button" @click="confirmLogout" class="inline-flex items-center rounded-full bg-red-600 px-3 py-1 text-xs font-semibold text-white shadow-sm transition hover:bg-red-500">Ya, keluar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </header>

                <main class="relative flex-1 overflow-y-auto">
                    <div class="p-6 space-y-4">
                        @if (session('status'))
                            <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                                {{ session('status') }}
                            </div>
                        @endif
                        @yield('content')
                        {{ $slot ?? '' }}
                    </div>
                </main>
            </div>
        </div>

        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 lg:hidden" @click="sidebarOpen = false"></div>
        <aside x-show="sidebarOpen" x-transition class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-950/95 p-6 text-white shadow-2xl ring-1 ring-slate-900/50 lg:hidden">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if ($companyLogoUrl)
                        <img src="{{ $companyLogoUrl }}" alt="{{ $companyName }}" class="h-10 w-auto rounded-lg border border-white/10 bg-white/90 p-1">
                    @endif
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="text-base font-semibold text-white">{{ $companyName }}</a>
                        <p class="text-xs text-slate-400">{{ $roleLabel ?? 'Admin' }} Panel</p>
                    </div>
                </div>
                <button type="button" class="rounded-md p-2 text-slate-400" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <nav class="mt-7 space-y-1.5 text-sm font-medium">
                @foreach ($links as $link)
                    @can($link['ability'])
                        @php($isActive = request()->routeIs($link['route']))
                        <a href="{{ route($link['route']) }}" class="group relative flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-150 {{ $isActive ? 'bg-white/15 text-white shadow-md shadow-slate-900/30' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-slate-300 transition group-hover:text-white {{ $isActive ? 'bg-white/20 text-white' : '' }}">
                                @php($icon = $link['icon'])
                                @include('partials.admin.icon', ['icon' => $icon])
                            </span>
                            <div class="flex flex-1 flex-col">
                                <span>{{ $link['label'] }}</span>
                                @if ($isActive)
                                    <span class="text-xs font-normal text-blue-200/80">Sedang dibuka</span>
                                @endif
                            </div>
                            <span class="absolute inset-y-0 right-0 w-1 rounded-r-xl bg-gradient-to-b from-blue-400 to-blue-600 opacity-0 transition group-hover:opacity-100 {{ $isActive ? 'opacity-100' : '' }}"></span>
                        </a>
                    @endcan
                @endforeach
            </nav>

            <div class="mt-6 rounded-2xl border border-white/10 bg-white/5 p-4 text-xs text-slate-300">
                <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400">{{ $roleLabel ?? 'Admin' }}</p>
                <p class="mt-3 text-[0.8rem]">Tetap terhubung dan responsif di mana pun Anda mengelola konten.</p>
            </div>
        </aside>
    </div>

    <div x-data="{
        notifications: [],
        init() {
            window.addEventListener('toast', (event) => {
                const detail = event.detail || {};
                const id = Date.now() + Math.random();
                this.notifications.push({ id, message: detail.message || 'Berhasil', type: detail.type || 'success', timeout: detail.timeout || 3000 });
                setTimeout(() => {
                    this.notifications = this.notifications.filter((item) => item.id !== id);
                }, detail.timeout || 3000);
            });
        }
    }" class="pointer-events-none fixed bottom-4 right-4 z-50 flex flex-col gap-3">
        <template x-for="notification in notifications" :key="notification.id">
            <div x-transition.opacity class="pointer-events-auto rounded-md px-4 py-2 text-sm text-white shadow-lg" :class="notification.type === 'error' ? 'bg-red-600/90 border border-red-200' : 'bg-slate-900/90 border border-slate-200'">
                <span x-text="notification.message"></span>
            </div>
        </template>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('notify', (event) => {
            window.dispatchEvent(new CustomEvent('toast', { detail: event.detail ?? { message: 'Berhasil' } }));
        });
    </script>
</body>
</html>
