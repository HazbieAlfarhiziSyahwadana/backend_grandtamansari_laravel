@extends('layouts.admin')

@section('content')
    <div class="space-y-6 max-w-3xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">{{ $pageTitle }}</h1>
                <p class="text-sm text-slate-500">Data komersial untuk katalog.</p>
            </div>
            <a href="{{ route('admin.commercials.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kembali</a>
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

        <form method="POST" action="{{ $commercial->exists ? route('admin.commercials.update', $commercial) : route('admin.commercials.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if($commercial->exists)
                @method('PUT')
            @endif

            <div class="grid gap-4 lg:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Nama</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $commercial->name) }}" required maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-slate-700">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $commercial->slug) }}" maxlength="191" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="otomatis jika dikosongkan">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="land_area" class="block text-sm font-medium text-slate-700">Luas Tanah</label>
                        <input type="number" id="land_area" name="land_area" value="{{ old('land_area', $commercial->land_area) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('land_area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="floor_area" class="block text-sm font-medium text-slate-700">Luas Bangunan</label>
                        <input type="number" id="floor_area" name="floor_area" value="{{ old('floor_area', $commercial->floor_area) }}" required min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('floor_area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label for="hargamulai" class="block text-sm font-medium text-slate-700">Harga Mulai</label>
                        <input type="text" id="hargamulai" name="hargamulai" value="{{ old('hargamulai', $commercial->hargamulai) }}" required maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('hargamulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="width" class="block text-sm font-medium text-slate-700">Lebar / Dimensi</label>
                        <input type="text" id="width" name="width" value="{{ old('width', $commercial->width) }}" required maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('width')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="img_commercial" class="block text-sm font-medium text-slate-700">Gambar Commercial</label>
                        <input type="file" id="img_commercial" name="img_commercial" accept="image/*" @if(!$commercial->exists) required @endif class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @if ($commercial->img_commercial)
                            <p class="mt-2 text-xs text-slate-500">Saat ini: {{ $commercial->img_commercial }}</p>
                        @endif
                        @error('img_commercial')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="img_area" class="block text-sm font-medium text-slate-700">Gambar Area</label>
                        <input type="file" id="img_area" name="img_area" accept="image/*" @if(!$commercial->exists) required @endif class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @if ($commercial->img_area)
                            <p class="mt-2 text-xs text-slate-500">Saat ini: {{ $commercial->img_area }}</p>
                        @endif
                        @error('img_area')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.commercials.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Simpan</button>
            </div>
        </form>
    </div>
@endsection