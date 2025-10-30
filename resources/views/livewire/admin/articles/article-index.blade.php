<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Articles</h1>
            <p class="text-sm text-slate-500">Kelola artikel berita dan promo.</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-500">Tambah Artikel</a>
    </div>

    <div class="flex flex-col gap-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-2">
                <label for="article-search" class="text-sm font-medium text-slate-600">Cari</label>
                <input id="article-search" type="search" wire:model.live.debounce.400ms="search" placeholder="Cari judul, slug, atau kata kunci" class="w-72 rounded-md border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>
            <div class="flex items-center gap-2">
                <label for="article-per-page" class="text-sm text-slate-600">Tampil</label>
                <select id="article-per-page" wire:model.live="perPage" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-slate-500">per halaman</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left">Sampul</th>
                        <th scope="col" class="px-4 py-3 cursor-pointer" wire:click="sortBy('title')">
                            <span class="inline-flex items-center gap-1">Judul <x-admin.sort-icon field="title" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="px-4 py-3 cursor-pointer" wire:click="sortBy('articletype_id')">
                            <span class="inline-flex items-center gap-1">Tipe <x-admin.sort-icon field="articletype_id" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="px-4 py-3 cursor-pointer" wire:click="sortBy('slug')">
                            <span class="inline-flex items-center gap-1">Slug <x-admin.sort-icon field="slug" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="cursor-pointer px-4 py-3 text-center" wire:click="sortBy('active')">
                            <span class="inline-flex items-center gap-1">Status <x-admin.sort-icon field="active" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="px-4 py-3 cursor-pointer" wire:click="sortBy('updated_at')">
                            <span class="inline-flex items-center gap-1">Diperbarui <x-admin.sort-icon field="updated_at" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-sm text-slate-700">
                    @forelse ($articles as $article)
                        <tr>
                            <td class="px-4 py-3">
                                @if ($article->image_url)
                                    <img src="{{ $article->image_url }}" alt="Sampul {{ $article->title }}" class="h-14 w-14 rounded-md object-cover">
                                @else
                                    <span class="text-xs text-slate-400">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ $article->title }}</div>
                                <div class="text-xs text-slate-500">ID: {{ $article->id }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $article->type?->type ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $article->slug }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($article->active)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ optional($article->updated_at)->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="inline-flex items-center rounded border border-slate-200 px-2 py-1 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">Edit</a>
                                    <button type="button" x-data="{}" @click.prevent="if (confirm('Hapus artikel ini?')) { $wire.delete({{ $article->id }}) }" class="inline-flex items-center rounded border border-red-100 px-2 py-1 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $articles->links() }}
        </div>
    </div>
</div>
