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
                    <button type="button" class="btn btn-primary mt-1 mb-3" data-bs-toggle="modal" id="btnTambahKategori">
                        Tambah Kategori
                    </button>
                </div>
                <div class="col-lg-12 mt-2">
                    <table class="table table-bordered table-responsive table-light table-striped shadow-sm"
                        id="tabel_master-kategori" width="100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategori as $data)
                                <tr>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->jenis }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-warning mx-2 btnEditKategori"
                                            data-id="{{ $data->id }}" data-nama="{{ $data->nama }}"
                                            data-jenis="{{ $data->jenis }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ url('Kategori/hapus_kategori') }}/" class="btn btn-danger tombol-hapus"
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
                    {{-- <a class="btn btn-primary btn-lg text-light fw-bolder"
                        href="{{ url('keuangan/kategoriToPdf') }}">PDF
                FILE</a> --}}
                </div>
        </section>
    </div>

    <!-- Modal Tambah/Edit Kategori -->
    <div class="modal fade" id="modalKategori" tabindex="-1" aria-labelledby="modalKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKategoriLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah/Edit Kategori -->
                    <form method="POST" id="formKategori" action="">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select class="form-control form-select" id="jenis" name="jenis">
                                <option value="PEMASUKAN">Pemasukan</option>
                                <option value="PENGELUARAN">Pengeluaran</option>
                            </select>
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
        $('#btnTambahKategori').click(function() {
            $('.validation-error').text('');
            $('#modalKategoriLabel').text('Tambah Kategori');
            $('#formKategori').attr('action', '{{ route('Kategori.tambah_kategori') }}');
            document.getElementById('formKategori').reset();
            $('#kategoriId').val('');
            $('#modalKategori').modal('show');
        });

        $('.btnEditKategori').click(function() {
            $('.validation-error').text('');

            // Mengambil data dari atribut data-*
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var jenis = $(this).data('jenis');

            // Mengisi form di dalam modal
            $('#modalKategori').find('#nama').val(nama);
            $('#modalKategori').find('#jenis').val(jenis);

            $('#modalKategoriLabel').text('Edit Kategori');
            $('#formKategori').attr('action',
                '{{ route('Kategori.ubah_kategori', '') }}/' + id);
            // Menampilkan modal
            $('#modalKategori').modal('show');
        });


        $('#formKategori').submit(function(e) {
            var isValid = true;

            $('.validation-error').text(''); // Bersihkan pesan error sebelumnya

            var nama = $('#nama').val().trim();
            if (nama === '') {
                $('#nama').next('.validation-error').text('Nama kategori harus diisi.');
                isValid = false;
            }

            var jenis = $('#jenis').val().trim();
            if (jenis === '') {
                $('#jenis').next('.validation-error').text('Jenis kategori harus diisi.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Jangan submit form jika validasi gagal
            }
        });
    </script>
@endsection
