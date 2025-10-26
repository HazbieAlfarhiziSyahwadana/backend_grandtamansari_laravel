@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">{{ $pageTitle }}</h1>
                <p class="text-sm text-slate-500">Kelola gambar slideshow untuk halaman utama.</p>
            </div>
            <a href="{{ route('admin.slideshows.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kembali</a>
        </div>

        <form method="POST" action="{{ $slideshow->exists ? route('admin.slideshows.update', $slideshow) : route('admin.slideshows.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($slideshow->exists)
                @method('PUT')
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700">Judul</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $slideshow->title) }}" maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Opsional">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="link" class="block text-sm font-medium text-slate-700">Tautan</label>
                        <input type="text" name="link" id="link" value="{{ old('link', $slideshow->link) }}" maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Opsional">
                        @error('link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sort" class="block text-sm font-medium text-slate-700">Urutan</label>
                        <input type="number" name="sort" id="sort" value="{{ old('sort', $slideshow->sort) }}" min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="0">
                        @error('sort')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="gambar_desktop" class="block text-sm font-medium text-slate-700">Gambar Desktop</label>
                        <input type="file" name="gambar_desktop" id="gambar_desktop" @if(!$slideshow->exists) required @endif accept="image/*" class="mt-1 block w-full text-sm text-slate-600">
                        @if ($slideshow->gambar_desktop)
                            <p class="mt-2 text-xs text-slate-500">Saat ini: <a href="{{ $slideshow->desktop_image_url ?? asset('storage/'.$slideshow->gambar_desktop) }}" target="_blank" class="text-blue-600 hover:underline">{{ $slideshow->gambar_desktop }}</a></p>
                        @endif
                        @error('gambar_desktop')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gambar_mobile" class="block text-sm font-medium text-slate-700">Gambar Mobile</label>
                        <input type="file" name="gambar_mobile" id="gambar_mobile" @if(!$slideshow->exists) required @endif accept="image/*" class="mt-1 block w-full text-sm text-slate-600">
                        @if ($slideshow->gambar_mobile)
                            <p class="mt-2 text-xs text-slate-500">Saat ini: <a href="{{ $slideshow->mobile_image_url ?? asset('storage/'.$slideshow->gambar_mobile) }}" target="_blank" class="text-blue-600 hover:underline">{{ $slideshow->gambar_mobile }}</a></p>
                        @endif
                        @error('gambar_mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection





