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

                    <!-- Status Aktif Unit - Checkbox dengan Animasi -->
                    <div class="form-group-animated">
                        <label class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200 cursor-pointer group">
                            <input type="checkbox" name="active" value="1" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-5 h-5 transition-all duration-200" 
                                   {{ old('active', $unitType->active) ? 'checked' : '' }}>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Aktifkan Unit</span>
                            </div>
                        </label>
                        @error('active')
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
                    <!-- Spesifikasi with Rich Text Editor (CKEditor) -->
                    <div>
                        <label for="specification" class="block text-sm font-medium text-slate-700 mb-1">Spesifikasi</label>
                        <textarea id="specification" name="specification" rows="12" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('specification', $unitType->specification) }}</textarea>
                        @error('specification')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keyword with Rich Text Editor (CKEditor) -->
                    <div>
                        <label for="keyword" class="block text-sm font-medium text-slate-700 mb-1">Keyword</label>
                        <textarea id="keyword" name="keyword" rows="4" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keyword', $unitType->keyword) }}</textarea>
                        @error('keyword')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Upload Gambar Facade (Desktop & Mobile) -->
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                <h3 class="text-sm font-semibold text-blue-900 mb-4">Gambar Facade</h3>
                <div class="grid gap-6 lg:grid-cols-2">
                    <!-- Facade Desktop -->
                    <div>
                        <label for="img_facade" class="block text-sm font-medium text-slate-700 mb-2">Facade Desktop</label>
                        <input type="file" id="img_facade" name="img_facade" accept="image/*" @if(!$unitType->exists) required @endif 
                               class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                               onchange="previewImage(this, 'preview-facade')">
                        @if ($unitType->img_facade)
                            <p class="mt-2 text-xs text-slate-500">File: <a href="{{ $unitType->facade_image_url ?? asset('storage/'.$unitType->img_facade) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($unitType->img_facade) }}</a></p>
                        @endif
                        <div id="preview-facade" class="mt-2">
                            @if ($unitType->img_facade)
                                <img src="{{ $unitType->facade_image_url ?? asset('storage/'.$unitType->img_facade) }}" alt="Preview" class="h-20 w-auto max-w-[140px] rounded-md border border-slate-300 object-cover bg-white shadow">
                            @endif
                        </div>
                        @error('img_facade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Facade Mobile -->
                    <div>
                        <label for="img_facade_mobile" class="block text-sm font-medium text-slate-700 mb-2">Facade Mobile <span class="text-xs text-slate-500">(Opsional)</span></label>
                        <input type="file" id="img_facade_mobile" name="img_facade_mobile" accept="image/*" 
                               class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                               onchange="previewImage(this, 'preview-facade-mobile')">
                        @if ($unitType->img_facade_mobile)
                            <p class="mt-2 text-xs text-slate-500">File: <a href="{{ $unitType->facade_mobile_image_url ?? asset('storage/'.$unitType->img_facade_mobile) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($unitType->img_facade_mobile) }}</a></p>
                        @else
                            <p class="mt-2 text-xs text-slate-500">Jika kosong, akan menggunakan gambar desktop</p>
                        @endif
                        <div id="preview-facade-mobile" class="mt-2">
                            @if ($unitType->img_facade_mobile)
                                <img src="{{ $unitType->facade_mobile_image_url ?? asset('storage/'.$unitType->img_facade_mobile) }}" alt="Preview" class="h-20 w-auto max-w-[140px] rounded-md border border-slate-300 object-cover bg-white shadow">
                            @endif
                        </div>
                        @error('img_facade_mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Layout Image -->
            <div class="rounded-lg border border-green-200 bg-green-50 p-4">
                <h3 class="text-sm font-semibold text-green-900 mb-4">Gambar Layout</h3>
                <div>
                    <label for="img_layout" class="block text-sm font-medium text-slate-700 mb-2">Gambar Layout</label>
                    <input type="file" id="img_layout" name="img_layout" accept="image/*" @if(!$unitType->exists) required @endif 
                           class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                           onchange="previewImage(this, 'preview-layout')">
                    @if ($unitType->img_layout)
                        <p class="mt-2 text-xs text-slate-500">File: <a href="{{ $unitType->layout_image_url ?? asset('storage/'.$unitType->img_layout) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($unitType->img_layout) }}</a></p>
                    @endif
                    <div id="preview-layout" class="mt-2">
                        @if ($unitType->img_layout)
                            <img src="{{ $unitType->layout_image_url ?? asset('storage/'.$unitType->img_layout) }}" alt="Preview" class="h-20 w-auto max-w-[140px] rounded-md border border-slate-300 object-cover bg-white shadow">
                        @endif
                    </div>
                    @error('img_layout')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Upload Gambar Gallery (Desktop & Mobile) -->
            <div class="rounded-lg border border-purple-200 bg-purple-50 p-4">
                <h3 class="text-sm font-semibold text-purple-900 mb-4">Gambar Gallery (Show Unit)</h3>
                <div class="grid gap-6 lg:grid-cols-2">
                    <!-- Gallery Desktop -->
                    <div>
                        <label for="img_gallery" class="block text-sm font-medium text-slate-700 mb-2">Gallery Desktop</label>
                        <input type="file" id="img_gallery" name="img_gallery" accept="image/*" 
                               class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100"
                               onchange="previewImage(this, 'preview-gallery')">
                        @if ($unitType->img_gallery)
                            <p class="mt-2 text-xs text-slate-500">File: <a href="{{ $unitType->gallery_image_url ?? asset('storage/'.$unitType->img_gallery) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($unitType->img_gallery) }}</a></p>
                        @endif
                        <div id="preview-gallery" class="mt-2">
                            @if ($unitType->img_gallery)
                                <img src="{{ $unitType->gallery_image_url ?? asset('storage/'.$unitType->img_gallery) }}" alt="Preview" class="h-20 w-auto max-w-[140px] rounded-md border border-slate-300 object-cover bg-white shadow">
                            @endif
                        </div>
                        @error('img_gallery')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gallery Mobile -->
                    <div>
                        <label for="img_gallery_mobile" class="block text-sm font-medium text-slate-700 mb-2">Gallery Mobile <span class="text-xs text-slate-500">(Opsional)</span></label>
                        <input type="file" id="img_gallery_mobile" name="img_gallery_mobile" accept="image/*" 
                               class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100"
                               onchange="previewImage(this, 'preview-gallery-mobile')">
                        @if ($unitType->img_gallery_mobile)
                            <p class="mt-2 text-xs text-slate-500">File: <a href="{{ $unitType->gallery_mobile_image_url ?? asset('storage/'.$unitType->img_gallery_mobile) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($unitType->img_gallery_mobile) }}</a></p>
                        @else
                            <p class="mt-2 text-xs text-slate-500">Jika kosong, akan menggunakan gambar desktop</p>
                        @endif
                        <div id="preview-gallery-mobile" class="mt-2">
                            @if ($unitType->img_gallery_mobile)
                                <img src="{{ $unitType->gallery_mobile_image_url ?? asset('storage/'.$unitType->img_gallery_mobile) }}" alt="Preview" class="h-20 w-auto max-w-[140px] rounded-md border border-slate-300 object-cover bg-white shadow">
                            @endif
                        </div>
                        @error('img_gallery_mobile')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Info Gallery (Caption, Alt Text, Sort, Gallery Active) -->
                <div class="mt-4 pt-4 border-t border-purple-300">
                    <h4 class="text-sm font-medium text-purple-900 mb-3">Informasi Gallery</h4>
                    <div class="grid gap-4 lg:grid-cols-4">
                        <div>
                            <label for="caption" class="block text-sm font-medium text-slate-700">Caption</label>
                            <input type="text" id="caption" name="caption" value="{{ old('caption', $unitType->caption) }}" maxlength="225" placeholder="LIVING ROOM" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <p class="mt-1 text-xs text-slate-500">Judul ruangan untuk gallery</p>
                            @error('caption')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="alt_text" class="block text-sm font-medium text-slate-700">Alt Text</label>
                            <input type="text" id="alt_text" name="alt_text" value="{{ old('alt_text', $unitType->alt_text) }}" maxlength="225" placeholder="Ruang Tamu Aira" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <p class="mt-1 text-xs text-slate-500">Untuk SEO dan accessibility</p>
                            @error('alt_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sort" class="block text-sm font-medium text-slate-700">Urutan</label>
                            <input type="number" id="sort" name="sort" value="{{ old('sort', $unitType->sort ?? 0) }}" min="0" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <p class="mt-1 text-xs text-slate-500">Semakin kecil semakin depan</p>
                            @error('sort')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Status Gallery</label>
                            <label class="flex items-center gap-2 p-2 bg-white rounded-lg hover:bg-purple-50 transition-colors cursor-pointer">
                                <input type="checkbox" name="gallery_active" value="1" 
                                       class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 w-4 h-4" 
                                       {{ old('gallery_active', $unitType->gallery_active) ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-gray-700">Aktifkan Gallery</span>
                            </label>
                            @error('gallery_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.unit-types.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Simpan</button>
            </div>
        </form>
    </div>

    <!-- CKEditor Script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        // Initialize CKEditor untuk Spesifikasi
        let specificationEditor;
        ClassicEditor
            .create(document.querySelector('#specification'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'undo', 'redo']
            })
            .then(editor => {
                specificationEditor = editor;
            })
            .catch(error => {
                console.error('Error initializing specification editor:', error);
            });

        // Initialize CKEditor untuk Keyword
        let keywordEditor;
        ClassicEditor
            .create(document.querySelector('#keyword'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo']
            })
            .then(editor => {
                keywordEditor = editor;
            })
            .catch(error => {
                console.error('Error initializing keyword editor:', error);
            });

        // Real-time Image Preview Function
        function previewImage(input, previewId) {
            const previewContainer = document.getElementById(previewId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Create new image element with BALANCED size (tidak terlalu besar, tidak terlalu kecil)
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.className = 'h-20 w-auto max-w-[140px] rounded-md border border-slate-300 object-cover bg-white shadow';
                    
                    // Clear and update container
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(img);
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection