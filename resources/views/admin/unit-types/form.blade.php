@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">{{ $pageTitle }}</h1>
                <p class="text-sm text-slate-500">Lengkapi detail unit hunian.</p>
            </div>
            <a href="{{ route('admin.unit-types.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kembali</a>
        </div>

        @if ($errors->any())
            <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">Terjadi kesalahan pada pengisian data:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $unitType->exists ? route('admin.unit-types.update', $unitType) : route('admin.unit-types.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($unitType->exists)
                @method('PUT')
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $unitType->name) }}" required maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-slate-700">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $unitType->slug) }}" maxlength="191" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="otomatis jika dikosongkan">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="land_area" class="block text-sm font-medium text-slate-700">Luas Tanah</label>
                            <input type="number" id="land_area" name="land_area" value="{{ old('land_area', $unitType->land_area) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('land_area')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="floor_area" class="block text-sm font-medium text-slate-700">Luas Bangunan</label>
                            <input type="number" id="floor_area" name="floor_area" value="{{ old('floor_area', $unitType->floor_area) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('floor_area')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="bedroom" class="block text-sm font-medium text-slate-700">Kamar</label>
                            <input type="number" id="bedroom" name="bedroom" value="{{ old('bedroom', $unitType->bedroom) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('bedroom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="bathroom" class="block text-sm font-medium text-slate-700">Kamar Mandi</label>
                            <input type="number" id="bathroom" name="bathroom" value="{{ old('bathroom', $unitType->bathroom) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('bathroom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="floor" class="block text-sm font-medium text-slate-700">Lantai</label>
                            <input type="number" id="floor" name="floor" value="{{ old('floor', $unitType->floor) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('floor')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="electricity" class="block text-sm font-medium text-slate-700">Listrik (Watt)</label>
                            <input type="number" id="electricity" name="electricity" value="{{ old('electricity', $unitType->electricity) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('electricity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="carport" class="block text-sm font-medium text-slate-700">Carport</label>
                            <input type="number" id="carport" name="carport" value="{{ old('carport', $unitType->carport) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('carport')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="sisa_unit" class="block text-sm font-medium text-slate-700">Sisa Unit</label>
                            <input type="number" id="sisa_unit" name="sisa_unit" value="{{ old('sisa_unit', $unitType->sisa_unit) }}" min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('sisa_unit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="width" class="block text-sm font-medium text-slate-700">Lebar / Dimensi</label>
                        <input type="text" id="width" name="width" value="{{ old('width', $unitType->width) }}" required maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('width')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-slate-700">Harga</label>
                            <input type="text" id="price" name="price" value="{{ old('price', $unitType->price) }}" maxlength="150" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="promo_price" class="block text-sm font-medium text-slate-700">Harga Promo</label>
                            <input type="text" id="promo_price" name="promo_price" value="{{ old('promo_price', $unitType->promo_price) }}" maxlength="150" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('promo_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="specification" class="block text-sm font-medium text-slate-700">Spesifikasi</label>
                        <textarea id="specification" name="specification" rows="12" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('specification', $unitType->specification) }}</textarea>
                        @error('specification')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keyword" class="block text-sm font-medium text-slate-700">Keyword</label>
                        <textarea id="keyword" name="keyword" rows="4" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keyword', $unitType->keyword) }}</textarea>
                        @error('keyword')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="img_facade" class="block text-sm font-medium text-slate-700">Gambar Fasade</label>
                        <input type="file" id="img_facade" name="img_facade" accept="image/*" @if(!$unitType->exists) required @endif class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @if ($unitType->img_facade)
                            <p class="mt-2 text-xs text-slate-500">Saat ini: {{ $unitType->img_facade }}</p>
                        @endif
                        @error('img_facade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="img_layout" class="block text-sm font-medium text-slate-700">Gambar Layout</label>
                        <input type="file" id="img_layout" name="img_layout" accept="image/*" @if(!$unitType->exists) required @endif class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @if ($unitType->img_layout)
                            <p class="mt-2 text-xs text-slate-500">Saat ini: {{ $unitType->img_layout }}</p>
                        @endif
                        @error('img_layout')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.unit-types.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Simpan</button>
            </div>
        </form>
    </div>
@endsection