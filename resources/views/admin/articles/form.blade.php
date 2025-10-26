@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">{{ $pageTitle }}</h1>
                <p class="text-sm text-slate-500">Formulir artikel Grand Tamansari Residence.</p>
            </div>
            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kembali</a>
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

        <form method="POST" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($article->exists)
                @method('PUT')
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700">Judul</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-slate-700">Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $article->slug) }}" maxlength="191" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="otomatis jika dikosongkan">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="articletype_id" class="block text-sm font-medium text-slate-700">Tipe Artikel</label>
                        <select id="articletype_id" name="articletype_id" required class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih tipe</option>
                            @foreach ($types as $id => $label)
                                <option value="{{ $id }}" @selected(old('articletype_id', $article->articletype_id) == $id)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('articletype_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="caption" class="block text-sm font-medium text-slate-700">Caption</label>
                        <input type="text" name="caption" id="caption" value="{{ old('caption', $article->caption) }}" maxlength="225" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('caption')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keyword" class="block text-sm font-medium text-slate-700">Keyword</label>
                        <textarea name="keyword" id="keyword" rows="3" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keyword', $article->keyword) }}</textarea>
                        @error('keyword')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="content" class="block text-sm font-medium text-slate-700">Konten</label>
                        <textarea name="content" id="content" rows="12" required class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content', $article->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gambar" class="block text-sm font-medium text-slate-700">Gambar</label>
                        <input type="file" name="gambar" id="gambar" accept="image/*" @if(!$article->exists) required @endif class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @if ($article->gambar)
                            <p class="mt-2 text-xs text-slate-500">Gambar saat ini: {{ $article->gambar }}</p>
                        @endif
                        @error('gambar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection