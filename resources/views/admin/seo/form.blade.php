@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">{{ $pageTitle }}</h1>
                <p class="text-sm text-slate-500">Formulir meta data SEO untuk halaman utama situs.</p>
            </div>
            <a href="{{ route('admin.seo.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kembali</a>
        </div>

        <form method="POST" action="{{ $seo->exists ? route('admin.seo.update', $seo) : route('admin.seo.store') }}" class="space-y-6">
            @csrf
            @if($seo->exists)
                @method('PUT')
            @endif

            <div class="space-y-4 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div>
                    <label for="page" class="block text-sm font-medium text-slate-700">Halaman</label>
                    <select id="page" name="page" @disabled($seo->exists) required class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih halaman</option>
                        @foreach ($pages as $pageOption)
                            <option value="{{ $pageOption->value }}" @selected(old('page', $seo->page?->value) === $pageOption->value)>{{ $pageOption->label() }}</option>
                        @endforeach
                    </select>
                    @error('page')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($seo->exists)
                        <p class="mt-1 text-xs text-slate-500">Halaman tidak dapat diubah.</p>
                    @endif
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $seo->title) }}" required maxlength="255" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="keyword" class="block text-sm font-medium text-slate-700">Keyword</label>
                    <textarea name="keyword" id="keyword" rows="3" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keyword', $seo->keyword) }}</textarea>
                    @error('keyword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $seo->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
