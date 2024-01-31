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
                    <button type="button" class="btn btn-primary mt-1 mb-3" data-bs-toggle="modal" id="btnTambahAkun">
                        Tambah Akun
                    </button>
                </div>
                <div class="col-lg-12 mt-2">
                    <table class="table table-bordered table-responsive table-light table-striped shadow-sm"
                        id="tabel_master-akun" width="100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Saldo Awal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($akun as $data)
                                <tr>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->jenis }}</td>
                                    <td class="text-end">{{ number_format($data->saldo_awal, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-warning btnEditAkun"
                                            data-id="{{ $data->id }}" data-nama="{{ $data->nama }}"
                                            data-jenis="{{ $data->jenis }}"
                                            data-saldo_awal="{{ number_format($data->saldo_awal, 0, ',', '.') }}">
                                            Edit
                                        </a>
                                        <a href="{{ url('Akun/hapus_akun') }}/" class="btn btn-danger tombol-hapus"
                                            data-id="{{ $data->id }}">Hapus</a>
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

    <!-- Modal Tambah/Edit Akun -->
    <div class="modal fade" id="modalAkun" tabindex="-1" aria-labelledby="modalAkunLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAkunLabel">Tambah Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah/Edit Akun -->
                    <form method="POST" id="formAkun" action="">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control form-select" id="jenis" name="jenis">
                                <option value="KAS">Kas</option>
                                <option value="BANK">Bank</option>
                                <option value="KARTU KREDIT">Kartu Kredit</option>
                            </select>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="saldo_awal">Saldo Awal (Rp)</label>
                            <input type="text" class="form-control uang" id="saldo_awal" name="saldo_awal"
                                autocomplete="off">
                            <small class="form-text text-danger validation-error"></small>
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
        $('#btnTambahAkun').click(function() {
            $('.validation-error').text('');
            $('#modalAkunLabel').text('Tambah Akun');
            $('#formAkun').attr('action', '{{ route('Akun.tambah_akun') }}');
            document.getElementById('formAkun').reset();
            $('#akunId').val('');
            $('#modalAkun').modal('show');
        });

        $('.btnEditAkun').click(function() {
            $('.validation-error').text('');

            // Mengambil data dari atribut data-*
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var jenis = $(this).data('jenis');
            var saldo_awal = $(this).data('saldo_awal');

            // Mengisi form di dalam modal
            $('#modalAkun').find('#nama').val(nama);
            $('#modalAkun').find('#jenis').val(jenis);
            $('#modalAkun').find('#saldo_awal').val(saldo_awal);

            $('#modalAkunLabel').text('Edit Akun');
            $('#formAkun').attr('action',
                '{{ route('Akun.ubah_akun', '') }}/' + id);
            // Menampilkan modal
            $('#modalAkun').modal('show');
        });


        $('#formAkun').submit(function(e) {
            var isValid = true;

            $('.validation-error').text(''); // Bersihkan pesan error sebelumnya

            var nama = $('#nama').val().trim();
            if (nama === '') {
                $('#nama').next('.validation-error').text('Nama akun harus diisi.');
                isValid = false;
            }

            var jenis = $('#jenis').val().trim();
            if (jenis === '') {
                $('#jenis').next('.validation-error').text('Jenis akun harus diisi.');
                isValid = false;
            }

            var saldo_awal = $('#saldo_awal').val().trim();
            if (saldo_awal === '') {
                $('#saldo_awal').next('.validation-error').text('Total akun harus diisi.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Jangan submit form jika validasi gagal
            }
        });
    </script>
@endsection
