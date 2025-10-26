@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">{{ $pageTitle }}</h1>
                <p class="text-sm text-slate-500">Atur tautan modul untuk navigasi cepat.</p>
            </div>
            <a href="{{ route('admin.modules.index') }}" class="inline-flex items-center rounded-md border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Kembali</a>
        </div>

        <form method="POST" action="{{ $module->exists ? route('admin.modules.update', $module) : route('admin.modules.store') }}" class="space-y-6">
            @csrf
            @if($module->exists)
                @method('PUT')
            @endif

            <div class="space-y-4 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div>
                    <label for="modul_link" class="block text-sm font-medium text-slate-700">Tautan Modul</label>
                    <input type="text" name="modul_link" id="modul_link" value="{{ old('modul_link', $module->modul_link) }}" required maxlength="255" class="mt-1 w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('modul_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-slate-700">Prioritas</label>
                    <input type="number" name="priority" id="priority" step="0.01" min="0" max="9.99" value="{{ old('priority', $module->priority) }}" required class="mt-1 w-40 rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">Nilai terkecil akan tampil lebih dulu.</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-500">
                    Simpan Module
                </button>
            </div>
        </form>
    </div>
@endsection
