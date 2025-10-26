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
                        <th scope="col" class="px-4 py-3 text-left">Harga</th>
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
                                <div>Harga: {{ $unit->price ?? '-' }}</div>
                                <div>Promo: {{ $unit->promo_price ?? '-' }}</div>
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
                            <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada unit type.</td>
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

