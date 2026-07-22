@extends('layouts.admin')

@section('title', 'Tambah Program Kerja')

@section('content')
<form method="POST" action="{{ route('admin.program-kerja.store') }}" enctype="multipart/form-data" class="max-w-xl bg-white rounded-2xl border border-emerald-900/10 p-6 space-y-4">
    @csrf
    @include('admin.program-kerja._form')
    <button type="submit" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 font-medium">Simpan</button>
</form>
@endsection
