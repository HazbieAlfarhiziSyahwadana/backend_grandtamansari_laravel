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
                <!-- KOLOM KIRI -->
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

                    <!-- Status Aktif - Checkbox dengan Animasi -->
                    <div class="form-group-animated">
                        <label class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer group">
                            <input type="checkbox" name="active" value="1" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-5 h-5 transition-all duration-200" 
                                   {{ old('active', $article->active) ? 'checked' : '' }}>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Aktifkan Artikel</span>
                            </div>
                        </label>
                        @error('active')
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
                        <label for="keyword" class="block text-sm font-medium text-slate-700 mb-1">Keyword</label>
                        <textarea name="keyword" id="keyword" rows="3" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keyword', $article->keyword) }}</textarea>
                        @error('keyword')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Gambar dengan Real-time Preview -->
                    <div>
                        <label for="gambar" class="block text-sm font-medium text-slate-700">Gambar Artikel</label>
                        <input type="file" name="gambar" id="gambar" accept="image/*" @if(!$article->exists) required @endif class="mt-1 block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" onchange="previewImage(event)">
                        
                        <!-- Preview Container -->
                        <div id="imagePreviewContainer" class="mt-3 {{ $article->gambar ? '' : 'hidden' }}">
                            <img id="imagePreview" src="{{ $article->image_url }}" alt="Preview" class="h-48 w-auto rounded-lg border border-slate-200 object-cover">
                            @if ($article->gambar)
                                <p class="mt-2 text-xs text-slate-500">File saat ini: <a href="{{ $article->image_url }}" target="_blank" class="text-blue-600 hover:underline">{{ $article->gambar }}</a></p>
                            @endif
                        </div>
                        
                        @error('gambar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- KOLOM KANAN -->
                <div class="space-y-4">
                    <div>
                        <label for="content" class="block text-sm font-medium text-slate-700 mb-1">Konten</label>
                        <textarea name="content" id="content" rows="28" required class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content', $article->content) }}</textarea>
                        @error('content')
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

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        // Initialize CKEditor untuk Content
        let contentEditor;
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'insertTable', 'undo', 'redo']
            })
            .then(editor => {
                contentEditor = editor;
            })
            .catch(error => {
                console.error('Error initializing content editor:', error);
            });

        // Initialize CKEditor untuk Keyword
        let keywordEditor;
        ClassicEditor
            .create(document.querySelector('#keyword'), {
                toolbar: ['bold', 'italic', '|', 'undo', 'redo']
            })
            .then(editor => {
                keywordEditor = editor;
            })
            .catch(error => {
                console.error('Error initializing keyword editor:', error);
            });

        // Real-time Image Preview Function
        function previewImage(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImg = document.getElementById('imagePreview');
            
            if (file) {
                // Check if file is an image
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    alert('Please select a valid image file');
                    event.target.value = '';
                }
            }
        }
    </script>
@endsection