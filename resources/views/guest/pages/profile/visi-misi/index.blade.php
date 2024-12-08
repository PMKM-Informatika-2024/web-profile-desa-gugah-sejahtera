@extends('guest.layouts.main')
@section('container')
    <div class="container my-5">
        <h2 class="mb-4 text-center">Visi & Misi Desa Gugah Sejahtera</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="border p-4 rounded" style="background-color: #f8f9fa;">
                    <h3 class="text-center">Visi</h3>
                    @foreach ($visi as $v)
                        <p>{{ $v->name }} : {{ $v->description }}</p>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                <div class="border p-4 rounded" style="background-color: #f8f9fa;">
                    <h3 class="text-center">Misi</h3>
                    @foreach ($misi as $m)
                        <p>{{ $m->name }} : {{ $m->description }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
