@extends('layouts.admin')

@section('content')
    @php
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $startOfMonth->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $startOfMonth->copy()->subDay();

        $totalArticles = \App\Models\Article::count();
        $articlesThisMonth = \App\Models\Article::where('created_at', '>=', $startOfMonth)->count();
        $articlesLastMonth = \App\Models\Article::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        $totalArticleTypes = \App\Models\ArticleType::count();
        $totalUnitTypes = \App\Models\UnitType::count();
        $totalUsers = \App\Models\User::count();
        $newUsersThisMonth = \App\Models\User::where('created_at', '>=', $startOfMonth)->count();
        $usersLastMonth = \App\Models\User::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        $recentArticles = \App\Models\Article::latest()->take(5)->get();
        $recentUsers = \App\Models\User::latest()->take(5)->get();
        $articleTypeDistribution = \App\Models\ArticleType::withCount('articles')->orderByDesc('articles_count')->take(4)->get();
        $articleTypeDistributionTotal = max($articleTypeDistribution->sum('articles_count'), 1);

        $variation = function (int $current, int $previous): array {
            if ($previous === 0) {
                return [
                    'percent' => $current > 0 ? 100 : 0,
                    'direction' => $current > 0 ? 'up' : 'neutral',
                ];
            }

            $value = round((($current - $previous) / $previous) * 100, 1);

            return [
                'percent' => $value,
                'direction' => $value > 0 ? 'up' : ($value < 0 ? 'down' : 'neutral'),
            ];
        };

        $statCards = [
            [
                'title' => 'Total Artikel',
                'value' => number_format($totalArticles),
                'description' => 'Konten aktif di website',
                'icon' => 'document-text',
                'trend' => $variation($articlesThisMonth, $articlesLastMonth),
                'trend_label' => 'Artikel baru bulan ini',
            ],
            [
                'title' => 'Tipe Konten',
                'value' => number_format($totalArticleTypes),
                'description' => 'Kategori artikel yang tersedia',
                'icon' => 'collection',
                'trend' => null,
            ],
            [
                'title' => 'Unit Types',
                'value' => number_format($totalUnitTypes),
                'description' => 'Variasi produk properti',
                'icon' => 'home-modern',
                'trend' => null,
            ],
            [
                'title' => 'Pengguna Terdaftar',
                'value' => number_format($totalUsers),
                'description' => 'Akses admin yang aktif',
                'icon' => 'users',
                'trend' => $variation($newUsersThisMonth, $usersLastMonth),
                'trend_label' => 'Pengguna baru bulan ini',
            ],
        ];

        $quickActions = collect([
            [
                'label' => 'Tambah Artikel',
                'description' => 'Publikasikan cerita atau berita terbaru.',
                'route' => route('admin.articles.create'),
                'icon' => 'plus-circle',
                'ability' => 'manage-content',
            ],
            [
                'label' => 'Kelola Slideshow',
                'description' => 'Perbarui visual utama homepage.',
                'route' => route('admin.slideshows.index'),
                'icon' => 'photo',
                'ability' => 'manage-content',
            ],
            [
                'label' => 'Perbarui Profil Perusahaan',
                'description' => 'Pastikan informasi kontak selalu akurat.',
                'route' => route('admin.profile.edit'),
                'icon' => 'building-office',
                'ability' => 'manage-content',
            ],
            [
                'label' => 'Buat Pengguna Baru',
                'description' => 'Tambahkan anggota tim atau vendor.',
                'route' => route('admin.users.create'),
                'icon' => 'user-plus',
                'ability' => 'manage-users',
            ],
        ])->filter(function ($action) {
            return empty($action['ability']) || auth()->user()->can($action['ability']);
        });
    @endphp

    <section class="space-y-6">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-slate-900 p-6 text-white shadow-xl lg:p-8">
            <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-xl space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">Selamat datang kembali</p>
                    <h2 class="text-2xl font-semibold leading-tight md:text-3xl">Dashboard Konten Grand Tamansari Residence</h2>
                    <p class="text-sm text-white/80">Pantau performa konten, kelola modul, dan pastikan informasi situs selalu terkini untuk pengunjung Anda.</p>
                </div>
                <div class="grid w-full max-w-xs gap-3 rounded-2xl bg-white/10 p-4 text-sm backdrop-blur lg:max-w-sm">
                    <div class="flex items-center justify-between text-white/80">
                        <span>Artikel baru bulan ini</span>
                        <span class="text-lg font-semibold text-white">{{ number_format($articlesThisMonth) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-white/80">
                        <span>Pengguna aktif</span>
                        <span class="text-lg font-semibold text-white">{{ number_format($totalUsers) }}</span>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-12 -right-10 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -top-16 -left-6 h-40 w-40 rounded-full bg-slate-200/20 blur-3xl"></div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($statCards as $card)
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $card['title'] }}</p>
                            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $card['value'] }}</p>
                        </div>
                        <span class="rounded-xl bg-slate-100 p-3 text-slate-600">
                            @php($icon = $card['icon'])
                            @if ($icon === 'document-text')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-6a2.25 2.25 0 0 0-2.25-2.25h-2.379a1.5 1.5 0 0 1-1.06-.44l-1.06-1.06a1.5 1.5 0 0 0-1.06-.44H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5A2.25 2.25 0 0 0 6.75 19.5h10.5a2.25 2.25 0 0 0 2.25-2.25Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9.75h7.5M8.25 13.5h5.25" />
                                </svg>
                            @elseif ($icon === 'collection')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A2.25 2.25 0 0 1 5.25 5.25h13.5A2.25 2.25 0 0 1 21 7.5v9a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 16.5v-9Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9h18M3 12h18" />
                                </svg>
                            @elseif ($icon === 'home-modern')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 4l9 6.5M4.5 10.5v7.875A1.125 1.125 0 0 0 5.625 19.5h2.25A1.125 1.125 0 0 0 9 18.375V15.75a1.125 1.125 0 0 1 1.125-1.125h3.75A1.125 1.125 0 0 1 15 15.75v2.625a1.125 1.125 0 0 0 1.125 1.125h2.25A1.125 1.125 0 0 0 19.5 18.375V10.5" />
                                </svg>
                            @elseif ($icon === 'users')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM4.5 18.75a4.5 4.5 0 0 1 9 0v.75a.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75v-.75ZM15.75 8.25a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM17.25 12.75a4.5 4.5 0 0 1 4.5 4.5v1.125a.375.375 0 0 1-.375.375h-4.5a.375.375 0 0 1-.375-.375V12.75Z" />
                                </svg>
                            @endif
                        </span>
                    </div>
                    <p class="mt-3 text-sm text-slate-500">{{ $card['description'] }}</p>

                    @if (!empty($card['trend']))
                        @php($trend = $card['trend'])
                        <div class="mt-4 inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium {{ $trend['direction'] === 'down' ? 'text-red-600' : ($trend['direction'] === 'up' ? 'text-emerald-600' : 'text-slate-500') }}">
                            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full {{ $trend['direction'] === 'down' ? 'bg-red-100 text-red-600' : ($trend['direction'] === 'up' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-200 text-slate-600') }}">
                                @if ($trend['direction'] === 'up')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                        <path fill-rule="evenodd" d="M10 3a.75.75 0 0 1 .75.75v10.544l3.045-3.045a.75.75 0 0 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.045 3.045V3.75A.75.75 0 0 1 10 3Z" clip-rule="evenodd" />
                                    </svg>
                                @elseif ($trend['direction'] === 'down')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                        <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.706L6.205 8.75a.75.75 0 1 1-1.06-1.06l4.5-4.5a.75.75 0 0 1 1.06 0l4.5 4.5a.75.75 0 1 1-1.06 1.06L10.75 5.706V16.25A.75.75 0 0 1 10 17Z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                        <path fill-rule="evenodd" d="M5 10a.75.75 0 0 1 .75-.75h8.5a.75.75 0 0 1 0 1.5h-8.5A.75.75 0 0 1 5 10Z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </span>
                            <span>{{ $card['trend_label'] ?? 'Perubahan' }}</span>
                            <span>{{ $trend['percent'] > 0 ? '+' : '' }}{{ $trend['percent'] }}%</span>
                        </div>
                    @endif

                    <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-blue-500/0 via-blue-500/20 to-blue-500/0 opacity-0 transition group-hover:opacity-100"></div>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                        <div>
                            <h3 class="text-base font-semibold text-slate-800">Artikel terbaru</h3>
                            <p class="text-sm text-slate-500">Kelola konten yang baru dipublikasikan dan pastikan tetap relevan.</p>
                        </div>
                        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-2 rounded-full border border-white bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700">
                            Lihat semua
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M10.75 4.75a.75.75 0 0 1 .75.75v3.75h3.75a.75.75 0 0 1 0 1.5H11.5v3.75a.75.75 0 0 1-1.5 0V10.75H6.25a.75.75 0 0 1 0-1.5H10V5.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>

                    <div class="mt-6 space-y-5">
                        @forelse ($recentArticles as $article)
                            <div class="flex flex-col gap-4 rounded-xl border border-slate-100 p-4 transition hover:border-blue-100 hover:bg-blue-50/50 sm:flex-row sm:items-center sm:justify-between">
                                <div class="space-y-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="text-sm font-semibold text-slate-800">{{ \Illuminate\Support\Str::limit($article->title, 60) }}</p>
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600">{{ optional($article->type)->type ?? 'Tanpa tipe' }}</span>
                                    </div>
                                    <p class="text-xs text-slate-500">Diperbarui {{ optional($article->updated_at)->diffForHumans() ?? 'Tidak ada data' }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="hidden text-xs text-slate-500 sm:block">{{ optional($article->created_at)->format('d M Y') }}</div>
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="inline-flex items-center gap-1 rounded-full border border-blue-200 px-3 py-1.5 text-xs font-medium text-blue-600 transition hover:bg-blue-600 hover:text-white">
                                        Kelola
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                            <path d="M12.293 2.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414L9.414 15H5a1 1 0 0 1-1-1v-4.414l8.293-8.293Z" />
                                            <path d="M5 17.25a.75.75 0 0 1 0-1.5h10a.75.75 0 0 1 0 1.5H5Z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500">
                                Belum ada artikel yang dipublikasikan. Mulai buat konten baru untuk mengisi dashboard ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                @if ($articleTypeDistribution->sum('articles_count') > 0)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-base font-semibold text-slate-800">Performa tipe artikel</h3>
                            <p class="text-sm text-slate-500">Kategori konten terpopuler berdasarkan jumlah artikel.</p>
                        </div>
                        <div class="mt-6 space-y-5">
                            @foreach ($articleTypeDistribution as $type)
                                <div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="font-medium text-slate-700">{{ $type->type }}</span>
                                        <span class="text-slate-500">{{ $type->articles_count }} artikel</span>
                                    </div>
                                    <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                                        <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-500" style="width: {{ max(6, round(($type->articles_count / $articleTypeDistributionTotal) * 100)) }}%;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                @if ($quickActions->isNotEmpty())
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-semibold text-slate-800">Quick actions</h3>
                        <p class="mt-1 text-sm text-slate-500">Akses cepat untuk pekerjaan yang sering dilakukan.</p>
                        <ul class="mt-5 space-y-3">
                            @foreach ($quickActions as $action)
                                <li>
                                    <a href="{{ $action['route'] }}" class="group flex items-start gap-3 rounded-xl border border-transparent p-3 transition hover:border-blue-100 hover:bg-blue-50">
                                        <span class="mt-1 rounded-lg bg-blue-100 p-2 text-blue-600">
                                            @php($actionIcon = $action['icon'])
                                            @if ($actionIcon === 'plus-circle')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z" clip-rule="evenodd" />
                                                </svg>
                                            @elseif ($actionIcon === 'photo')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                    <path fill-rule="evenodd" d="M3.5 4A1.5 1.5 0 0 0 2 5.5v9A1.5 1.5 0 0 0 3.5 16h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 16.5 4h-13Zm3.75 9.25 2.775-3.1a.75.75 0 0 1 1.15 0l2.275 2.539 1.017-1.13a.75.75 0 0 1 1.116.996l-1.575 1.75a.75.75 0 0 1-1.104.014l-2.27-2.533-2.78 3.104a.75.75 0 0 1-1.104.001l-1.75-1.95a.75.75 0 0 1 1.12-.996l1.11 1.238Z" clip-rule="evenodd" />
                                                </svg>
                                            @elseif ($actionIcon === 'building-office')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                    <path d="M3 4.25A2.25 2.25 0 0 1 5.25 2h3.5A2.25 2.25 0 0 1 11 4.25v11.5C11 16.99 10 18 8.75 18h-5A2.25 2.25 0 0 1 1.5 15.75V7.25H3v7.8c0 .69.56 1.25 1.25 1.25H8.5a.75.75 0 0 0 .75-.75V4.25a.75.75 0 0 0-.75-.75h-3.5a.75.75 0 0 0-.75.75V6.5H3V4.25Z" />
                                                    <path d="M12.5 6.5a.5.5 0 0 1 .5-.5h3.25A2.75 2.75 0 0 1 19 8.75v7.5A2.75 2.75 0 0 1 16.25 19h-2A1.75 1.75 0 0 1 12.5 17.25V6.5Z" />
                                                </svg>
                                            @elseif ($actionIcon === 'user-plus')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                    <path d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                    <path fill-rule="evenodd" d="M2 15a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4 2 2 0 0 1-2 2H4a2 2 0 0 1-2-2Z" clip-rule="evenodd" />
                                                    <path d="M16.25 6.5a.75.75 0 0 1 .75.75v1.25h1.25a.75.75 0 0 1 0 1.5H17v1.25a.75.75 0 0 1-1.5 0V10h-1.25a.75.75 0 0 1 0-1.5H15V7.25a.75.75 0 0 1 .75-.75Z" />
                                                </svg>
                                            @endif
                                        </span>
                                        <span>
                                            <span class="font-medium text-slate-800">{{ $action['label'] }}</span>
                                            <p class="text-sm text-slate-500">{{ $action['description'] }}</p>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-base font-semibold text-slate-800">Aktivitas tim terbaru</h3>
                        <p class="text-sm text-slate-500">Pantau siapa saja yang terakhir bergabung dan aktivitas terbaru tim.</p>
                    </div>
                    <ul class="mt-5 space-y-4">
                        @forelse ($recentUsers as $user)
                            <li class="flex items-center justify-between gap-3 rounded-xl border border-transparent p-3 transition hover:border-blue-100 hover:bg-blue-50">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-semibold text-slate-600">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                    <div>
                                        <p class="text-sm font-medium text-slate-700">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">Bergabung {{ optional($user->created_at)->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="max-w-[150px] truncate text-xs text-slate-500">{{ $user->email }}</div>
                            </li>
                        @empty
                            <li class="rounded-xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center text-sm text-slate-500">
                                Belum ada aktivitas tim terbaru.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
