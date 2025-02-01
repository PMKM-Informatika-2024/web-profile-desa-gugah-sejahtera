@extends('admin.layouts.main')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard | Pemerintahan Desa</h1>
    </div>

    <!-- Struktur Organisasi Section -->
    <h2>Struktur Organisasi</h2>
    @if ($struktur->isEmpty())
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Struktur Desa
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Fasilitas Desa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('struktur.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="addStructureDescription" class="form-label">Keterangan</label>
                                <input id="addStructureDescription" type="hidden" name="description" required>
                                <trix-editor input="addStructureDescription"></trix-editor>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="image" name="image_url" accept="image/*"
                                    onchange="loadFile(event)">
                                <img id="preview" class="img-fluid w-100 my-3">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data (Replace this with dynamic data from the database) -->
                    @foreach ($struktur as $s)
                        <tr>
                            <td>
                                {{ $s->name }}
                            </td>
                            <td>
                                {!! $s->description !!}
                            </td>
                            <td>
                                @if ($s->image_url)
                                    <img src="{{ asset('storage/' . $s->image_url) }}" alt="Fasilitas Image" width="300">
                                @else
                                    tidak ada gambar
                                @endif
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#strukturData-{{ $s->id }}">
                                    Edit
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="strukturData-{{ $s->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Struktur :
                                                    {{ $s->name }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('struktur.update', ['pemerintahan' => $s->id]) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Nama</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $s->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="editStrukturDesc-{{ $s->id }}"
                                                            class="form-label">Keterangan</label>
                                                        <input id="editStrukturDesc-{{ $s->id }}" type="hidden"
                                                            name="description" required value="{{ $s->description }}">
                                                        <trix-editor input="editStrukturDesc-{{ $s->id }}">
                                                        </trix-editor>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="oldImage" class="form-label">Gambar Lama</label>
                                                        @if ($s->image_url)
                                                            <div class="text-center">
                                                                <img id="preview-{{ $s->id }}"
                                                                    class="img-fluid w-100 my-3"
                                                                    src="{{ $s->image_url ? asset('storage/' . $s->image_url) : '' }}">
                                                            </div>
                                                        @else
                                                            tidak ada gambar
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Gambar</label>
                                                        <input type="file" class="form-control" id="image"
                                                            name="image_url" accept="image/*"
                                                            onchange="loadFile(event, {{ $s->id }})">
                                                        <img id="preview-{{ $s->id }}"
                                                            class="img-fluid w-100 my-3">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('struktur.delete', ['pemerintahan' => $s->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus?');"
                                        class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <!-- Add more entries as needed -->
                </tbody>
            </table>
        </div>
    @endif


    <!-- Program Kerja Section -->
    <h2 class="mt-5">Program Kerja</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProgramModal">Tambah Program
        Kerja</button>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Deskripsi</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programkerja as $pk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pk->name }}</td>
                        <td>{{ $pk->description }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editProgramModal">Edit</button>
                                <form action="{{ route('hapus program', ['id' => $pk->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                <!-- Add more entries as needed -->
            </tbody>
        </table>
    </div>

    <!-- Modal for Adding Program Kerja -->
    <div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProgramModalLabel">Tambah Program Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('saveprogram') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="programTitle" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="programTitle" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="programDescription" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="programDescription" name="description" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var loadFile = function(event, id = null) {
            var previewId = id ? 'preview-' + id : 'preview';
            var preview = document.getElementById(previewId);
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.onload = function() {
                URL.revokeObjectURL(preview.src); // free memory
            }
        };
    </script>
@endsection
