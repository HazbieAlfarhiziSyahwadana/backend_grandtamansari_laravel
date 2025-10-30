<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">SEO</h1>
            <p class="text-sm text-slate-500">Atur meta data untuk setiap halaman.</p>
        </div>
        <a href="{{ route('admin.seo.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-500">Tambah Data SEO</a>
    </div>

    <div class="flex flex-col gap-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-2">
                <label for="seo-search" class="text-sm font-medium text-slate-600">Cari</label>
                <input id="seo-search" type="search" wire:model.live.debounce.400ms="search" placeholder="Cari judul dan keyword" class="w-64 rounded-md border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>
            <div class="flex items-center gap-2">
                <label for="seo-per-page" class="text-sm text-slate-600">Tampil</label>
                <select id="seo-per-page" wire:model.live="perPage" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                        <th scope="col" class="cursor-pointer px-4 py-3 text-left" wire:click="sortBy('page')">
                            <span class="inline-flex items-center gap-1">Halaman <x-admin.sort-icon field="page" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="cursor-pointer px-4 py-3 text-left" wire:click="sortBy('title')">
                            <span class="inline-flex items-center gap-1">Judul <x-admin.sort-icon field="title" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left">Keyword</th>
                        <th scope="col" class="cursor-pointer px-4 py-3 text-left" wire:click="sortBy('updated_at')">
                            <span class="inline-flex items-center gap-1">Diperbarui <x-admin.sort-icon field="updated_at" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-sm text-slate-700">
                    @forelse ($records as $seo)
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $seo->page?->label() ?? ucfirst($seo->page?->value ?? '-') }}</td>
                            <td class="px-4 py-3">{{ $seo->title }}</td>
                            <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($seo->keyword ?? '-', 60) }}</td>
                            <td class="px-4 py-3">{{ optional($seo->updated_at)->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.seo.edit', $seo) }}" class="inline-flex items-center rounded border border-slate-200 px-2 py-1 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">Edit</a>
                                    <button type="button" x-data="{}" @click.prevent="if (confirm('Hapus data SEO ini?')) { $wire.delete({{ $seo->id }}) }" class="inline-flex items-center rounded border border-red-100 px-2 py-1 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada data SEO.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $records->links() }}
        </div>
    </div>
</div>

