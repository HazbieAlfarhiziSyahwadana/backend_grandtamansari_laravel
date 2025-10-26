@extends('layouts.admin')

@section('content')
    <div class="space-y-6 max-w-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">{{ $pageTitle }}</h1>
                <p class="text-sm text-slate-500">Tipe artikel menentukan kategori konten.</p>
            </div>
            <a href="{{ route('admin.article-types.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kembali</a>
        </div>

        <form method="POST" action="{{ $articleType->exists ? route('admin.article-types.update', $articleType) : route('admin.article-types.store') }}" class="space-y-4">
            @csrf
            @if($articleType->exists)
                @method('PUT')
            @endif

            <div>
                <label for="type" class="block text-sm font-medium text-slate-700">Nama Tipe</label>
                <input type="text" name="type" id="type" value="{{ old('type', $articleType->type) }}" required maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.article-types.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Simpan</button>
            </div>
        </form>
    </div>
@endsection