@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        @if (session('sukses'))
            <div class="modal-sukses" data-flashdata="{{ session('sukses') }}"></div>
        @endif
        @if (session('gagal'))
            <div class="modal-gagal" data-flashdata="{{ session('gagal') }}"></div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="modal-gagal" data-flashdata="{{ $error }}"></div>
            @endforeach
        @endif
        <section class="section">
            <div class="row mt-5">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary mt-1 mb-3" data-bs-toggle="modal" id="btnTambahAnggota">
                        Tambah Anggota
                    </button>
                </div>
                <div class="col-lg-12 mt-2">
                    <table class="table table-bordered table-responsive table-light table-striped shadow-sm"
                        id="tabel_master-anggota">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Hubungan</th>
                                <th>Tanggal Lahir</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $data)
                                <tr>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->hubungan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tgl_lahir)->format('d-m-Y') }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->no_telp }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-warning mx-2 btnEditAnggota"
                                            data-id="{{ $data->id }}" data-nama="{{ $data->nama }}"
                                            data-hubungan="{{ $data->hubungan }}" data-tgl_lahir="{{ $data->tgl_lahir }}"
                                            data-email="{{ $data->email }}" data-no_telp="{{ $data->no_telp }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ url('Anggota/hapus_anggota') }}/" class="btn btn-danger tombol-hapus"
                                            data-id="{{ $data->id }}"><i class="fas fa-trash-alt"></i></a>
                                        <form id="form-hapus" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </section>
    </div>

    <!-- Modal Tambah/Edit Anggota -->
    <div class="modal fade" id="modalAnggota" tabindex="-1" aria-labelledby="modalAnggotaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAnggotaLabel">Tambah Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah/Edit Anggota -->
                    <form method="POST" id="formAnggota" action="">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off"
                                placeholder="Nama Anggota">
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="hubungan">Hubungan</label>
                            <select class="form-control form-select" id="hubungan" name="hubungan">
                                <option value="SUAMI">Suami</option>
                                <option value="ISTRI">Istri</option>
                                <option value="ANAK">Anak</option>
                            </select>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" autocomplete="off"
                                placeholder="dd-mm-yyyy">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off"
                                placeholder="email@gmail.com">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" autocomplete="off"
                                placeholder="628xxxxxxxxx">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#btnTambahAnggota').click(function() {
            $('.validation-error').text('');
            $('#modalAnggotaLabel').text('Tambah Anggota');
            $('#formAnggota').attr('action', '{{ route('Anggota.tambah_anggota') }}');
            document.getElementById('formAnggota').reset();
            $('#modalAnggota').modal('show');
        });

        $('.btnEditAnggota').click(function() {
            $('.validation-error').text('');

            // Mengambil data dari atribut data-*
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var hubungan = $(this).data('hubungan');
            var tgl_lahir = $(this).data('tgl_lahir');
            var email = $(this).data('email');
            var no_telp = $(this).data('no_telp');

            // Mengisi form di dalam modal
            $('#modalAnggota').find('#nama').val(nama);
            $('#modalAnggota').find('#hubungan').val(hubungan);
            $('#modalAnggota').find('#tgl_lahir').val(tgl_lahir);
            $('#modalAnggota').find('#email').val(email);
            $('#modalAnggota').find('#no_telp').val(no_telp);

            $('#modalAnggotaLabel').text('Edit Anggota');
            $('#formAnggota').attr('action',
                '{{ route('Anggota.ubah_anggota', '') }}/' + id);
            // Menampilkan modal
            $('#modalAnggota').modal('show');
        });


        $('#formAnggota').submit(function(e) {
            var isValid = true;

            $('.validation-error').text(''); // Bersihkan pesan error sebelumnya

            var nama = $('#nama').val().trim();
            if (nama === '') {
                $('#nama').next('.validation-error').text('Nama anggota harus diisi.');
                isValid = false;
            }

            var hubungan = $('#hubungan').val().trim();
            if (hubungan === '') {
                $('#hubungan').next('.validation-error').text('Jenis anggota harus diisi.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
@endsection
