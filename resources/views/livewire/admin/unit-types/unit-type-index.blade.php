<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Unit Types</h1>
            <p class="text-sm text-slate-500">Kelola tipe unit hunian Grand Tamansari.</p>
        </div>
        <a href="{{ route('admin.unit-types.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-500">Tambah Unit Type</a>
    </div>

    <div class="flex flex-col gap-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-slate-600" for="unit-search">Cari</label>
                <input id="unit-search" type="search" wire:model.live.debounce.400ms="search" placeholder="Cari nama atau slug" class="w-64 rounded-md border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>
            <div class="flex items-center gap-2">
                <label for="unit-per-page" class="text-sm text-slate-600">Tampil</label>
                <select id="unit-per-page" wire:model.live="perPage" class="rounded-md border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                        <th scope="col" class="px-4 py-3 text-left">Fasad</th>
                        <th scope="col" class="cursor-pointer px-4 py-3 text-left" wire:click="sortBy('name')">
                            <span class="inline-flex items-center gap-1">Nama <x-admin.sort-icon field="name" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="cursor-pointer px-4 py-3 text-left" wire:click="sortBy('slug')">
                            <span class="inline-flex items-center gap-1">Slug <x-admin.sort-icon field="slug" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left">Luas</th>
                        <th scope="col" class="px-4 py-3 text-left">Gallery</th>
                        <th scope="col" class="px-4 py-3 text-left">Spesifikasi</th>
                        <th scope="col" class="px-4 py-3 text-left">Harga</th>
                        <th scope="col" class="cursor-pointer px-4 py-3 text-center" wire:click="sortBy('sort')">
                            <span class="inline-flex items-center gap-1">Urutan <x-admin.sort-icon field="sort" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="cursor-pointer px-4 py-3 text-center" wire:click="sortBy('active')">
                            <span class="inline-flex items-center gap-1">Status <x-admin.sort-icon field="active" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="cursor-pointer px-4 py-3 text-left" wire:click="sortBy('updated_at')">
                            <span class="inline-flex items-center gap-1">Diperbarui <x-admin.sort-icon field="updated_at" :current="$sortField" :direction="$sortDirection" /></span>
                        </th>
                        <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white text-sm text-slate-700">
                    @forelse ($unitTypes as $unit)
                        <tr>
                            <td class="px-4 py-3">
                                @if ($unit->facade_image_url)
                                    <img src="{{ $unit->facade_image_url }}" alt="Fasad {{ $unit->name }}" class="h-14 w-14 rounded-md object-cover">
                                @else
                                    <span class="text-xs text-slate-400">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-slate-800">
                                <div>{{ $unit->name }}</div>
                                <div class="text-xs text-slate-500">ID: {{ $unit->id }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $unit->slug }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div>LT: {{ $unit->land_area }} m&sup2;</div>
                                <div>LB: {{ $unit->floor_area }} m&sup2;</div>
                            </td>
                            <td class="px-4 py-3">
                                @if($unit->img_gallery)
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $unit->gallery_image_url }}" alt="Gallery" class="h-10 w-10 rounded object-cover">
                                        <div class="text-xs">
                                            <div class="font-medium text-purple-700">{{ $unit->caption ?? '-' }}</div>
                                            @if($unit->gallery_active)
                                                <span class="text-green-600">✓ Aktif</span>
                                            @else
                                                <span class="text-gray-500">○ Nonaktif</span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">Tidak ada gallery</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm max-w-xs">
                                @if($unit->specification)
                                    <div class="group relative">
                                        <div class="truncate text-slate-600">
                                            {{ Str::limit(strip_tags($unit->specification), 40) }}
                                        </div>
                                        <div class="pointer-events-none absolute left-0 top-full z-10 mt-1 hidden w-64 rounded-lg border border-slate-200 bg-white p-3 shadow-lg group-hover:block">
                                            <div class="text-xs text-slate-700">
                                                {!! Str::limit($unit->specification, 200) !!}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">Tidak ada spesifikasi</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div>Harga: {{ $unit->price ?? '-' }}</div>
                                <div>Promo: {{ $unit->promo_price ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                    {{ $unit->sort }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($unit->active)
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
                            <td class="px-4 py-3">{{ optional($unit->updated_at)->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.unit-types.edit', $unit) }}" class="inline-flex items-center rounded border border-slate-200 px-2 py-1 text-xs font-semibold text-slate-600 transition hover:bg-slate-100">Edit</a>
                                    <button type="button" x-data="{}" @click.prevent="if (confirm('Hapus unit type ini?')) { $wire.delete({{ $unit->id }}) }" class="inline-flex items-center rounded border border-red-100 px-2 py-1 text-xs font-semibold text-red-600 transition hover:bg-red-50">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada unit type.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $unitTypes->links() }}
        </div>
    </div>
</div>