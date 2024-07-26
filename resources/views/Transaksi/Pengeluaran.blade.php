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
                <div class="col-lg-12 mt-2">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary shadow-light mt-1 mb-3" data-bs-toggle="modal"
                                id="btnTambahPengeluaran">
                                Tambah Pengeluaran
                                <i class="fas fa-plus-circle ps-1"></i>
                            </button>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ url('Pengeluaran/cari_pengeluaran') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <select class="form-control form-select" id="bulan" name="bulan">
                                            @php
                                                $bulan = [
                                                    'Januari',
                                                    'Februari',
                                                    'Maret',
                                                    'April',
                                                    'Mei',
                                                    'Juni',
                                                    'Juli',
                                                    'Agustus',
                                                    'September',
                                                    'Oktober',
                                                    'November',
                                                    'Desember',
                                                ];
                                                $bln = session('bulanPenjualan', date('n')) - 1;
                                            @endphp
                                            @foreach ($bulan as $index => $namaBulan)
                                                <option value="{{ $index + 1 }}" {{ $index == $bln ? 'selected' : '' }}>
                                                    {{ $namaBulan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <select class="form-control form-select" id="tahun" name="tahun"
                                            title="Pilih Tahun">
                                            @php
                                                $tahunSekarang = date('Y');
                                                $tahunDipilih = session('tahunPenjualan', $tahunSekarang);
                                            @endphp
                                            @for ($i = $tahunSekarang - 1; $i <= $tahunSekarang + 5; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $tahunDipilih ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2 mt-1">
                                        <button type="submit" class="btn btn-primary shadow-light">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-responsive table-light table-striped shadow-sm"
                            id="tabel-keuangan" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center">Tanggal Transaksi</th>
                                    <th scope="col" class="text-center">Kategori</th>
                                    <th scope="col" class="text-center">Akun</th>
                                    <th scope="col" class="text-center">Penanggung Jawab</th>
                                    <th scope="col" class="text-center">Total Transaksi (Rp)</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengeluaran as $data)
                                    <tr>
                                        <td class="text-capitalize keterangan">{{ $data->keterangan }}</td>
                                        <td class="text-center tgl_transaksi">
                                            {{ \Carbon\Carbon::parse($data->tgl_transaksi)->format('d-m-Y') }}</td>
                                        <td class="text-capitalize kategori">{{ $data->Kategori?->nama }}</td>
                                        <td class="text-capitalize akun">{{ $data->Akun?->nama }}
                                            ({{ $data->Akun?->jenis }})
                                        </td>
                                        <td class="text-capitalize akun">{{ $data->User?->name }}
                                            ({{ $data->User?->hubungan }})
                                        </td>
                                        <td class="text-center fw-bold total_transaksi">
                                            {{ number_format($data->total_transaksi, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @if (Gate::allows('role-admin') || $data->id_user == Auth::user()->id)
                                                <a href="javascript:void(0)"
                                                    class="btn btn-warning shadow-warning mx-2 btnEditPengeluaran"
                                                    data-id="{{ $data->id }}"
                                                    data-keterangan="{{ $data->keterangan }}"
                                                    data-tgl_transaksi="{{ \Carbon\Carbon::parse($data->tgl_transaksi)->format('d-m-Y') }}"
                                                    data-id_kategori="{{ $data->Kategori?->id }}"
                                                    data-kategori="{{ $data->Kategori?->nama }}"
                                                    data-id_akun="{{ $data->Akun?->id }}"
                                                    data-akun="{{ $data->Akun?->nama }}"
                                                    data-id_pj="{{ $data->User?->id }}"
                                                    data-pj="{{ $data->User?->name }} ({{ $data->User?->hubungan }})"
                                                    data-total_transaksi="{{ number_format($data->total_transaksi, 0, ',', '.') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ url('Pengeluaran/hapus_pengeluaran') }}/"
                                                    class="btn btn-danger shadow-danger tombol-hapus"
                                                    data-id="{{ $data->id }}"><i class="fas fa-trash-alt"></i></a>
                                                <form class="form-hapus" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-center fw-bold">
                                    <td colspan="5" class="text-center">Total:</td>
                                    <td class="text-center fw-bold"></td>
                                    <td class="text-center"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
        </section>
    </div>

    <!-- Modal Tambah/Edit Pengeluaran -->
    <div class="modal fade" id="modalPengeluaran" tabindex="-1" aria-labelledby="modalPengeluaranLabel" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPengeluaranLabel">Tambah Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah/Edit Pengeluaran -->
                    <form method="POST" id="formPengeluaran" action="">
                        @csrf
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                autocomplete="off">
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_transaksi" class="form-label">Tanggal</label>
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control datepicker" id="tgl_transaksi"
                                    name="tgl_transaksi" autocomplete="off" value="{{ date('d-m-Y') }}">
                                <span class="input-group-text">📅</span>
                            </div>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-control" id="kategori" name="id_kategori">
                            </select>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="mb-3">
                            <label for="akun" class="form-label">Akun</label>
                            <select class="form-control" id="akun" name="id_akun">
                            </select>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="mb-3">
                            <label for="pj" class="form-label">Penanggung Jawab</label>
                            <select class="form-control" id="pj" name="id_pj">
                            </select>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="mb-3">
                            <label for="total_transaksi" class="form-label">Total Pengeluaran (Rp)</label>
                            <input type="text" class="form-control uang" id="total_transaksi" name="total_transaksi"
                                autocomplete="off">
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger shadow-danger"
                                data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary shadow-light">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
    <script>
        $(document).ready(function() {
            $('#modalPengeluaran').on('shown.bs.modal', function() {
                // SELECT HARI AWAL
                $('#akun').select2({
                    theme: 'bootstrap-5',
                    ajax: {
                        url: "{{ route('Pengeluaran.getAkun') }}",
                        dataType: 'json',
                        // delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Pilih Akun',
                    // minimumInputLength: 3,
                    allowClear: true,
                    templateResult: function(data) {
                        if (data.loading) {
                            return data.text;
                        }
                        return $('<span>').text(data.text);
                    }
                });

                $('#kategori').select2({
                    theme: 'bootstrap-5',
                    ajax: {
                        url: "{{ route('Pengeluaran.getKategori') }}",
                        dataType: 'json',
                        // delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Pilih Kategori',
                    // minimumInputLength: 3,
                    allowClear: true,
                    templateResult: function(data) {
                        if (data.loading) {
                            return data.text;
                        }
                        return $('<span>').text(data.text);
                    }
                });

                $('#pj').select2({
                    theme: 'bootstrap-5',
                    ajax: {
                        url: "{{ route('Pengeluaran.getPJ') }}",
                        dataType: 'json',
                        // delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Pilih Penanggung Jawab',
                    // minimumInputLength: 3,
                    allowClear: true,
                    templateResult: function(data) {
                        if (data.loading) {
                            return data.text;
                        }
                        return $('<span>').text(data.text);
                    }
                });
            });

            $('#btnTambahPengeluaran').click(function() {
                $('.validation-error').text('');
                $('#modalPengeluaranLabel').text('Tambah Pengeluaran');
                $('#formPengeluaran').attr('action', '{{ route('Pengeluaran.tambah_pengeluaran') }}');
                document.getElementById('formPengeluaran').reset();
                $('#kategori').val(null).trigger('change');
                $('#akun').val(null).trigger('change');
                $('#modalPengeluaran').modal('show');
            });

            $('.btnEditPengeluaran').click(function() {
                $('.validation-error').text('');

                // Mengambil data dari atribut data-*
                var id = $(this).data('id');
                var keterangan = $(this).data('keterangan');
                var tgl_transaksi = $(this).data('tgl_transaksi');
                var id_kategori = $(this).data('id_kategori');
                var kategori = $(this).data('kategori');
                var id_akun = $(this).data('id_akun');
                var akun = $(this).data('akun');
                var id_pj = $(this).data('id_pj');
                var pj = $(this).data('pj');
                var total_transaksi = $(this).data('total_transaksi');

                // Mengisi form di dalam modal
                $('#modalPengeluaran').find('#keterangan').val(keterangan);
                $('#modalPengeluaran').find('#tgl_transaksi').val(tgl_transaksi);
                var optionKategori = $('<option></option>')
                    .attr('value', id_kategori)
                    .attr('selected', 'selected')
                    .text(kategori);
                $('#modalPengeluaran').find('#kategori').append(optionKategori);
                var optionAkun = $('<option></option>')
                    .attr('value', id_akun)
                    .attr('selected', 'selected')
                    .text(akun);
                $('#modalPengeluaran').find('#akun').append(optionAkun);
                var optionPJ = $('<option></option>')
                    .attr('value', id_pj)
                    .attr('selected', 'selected')
                    .text(pj);
                $('#modalPengeluaran').find('#pj').append(optionPJ);

                $('#modalPengeluaran').find('#total_transaksi').val(total_transaksi);

                $('#modalPengeluaranLabel').text('Edit Pengeluaran');
                $('#formPengeluaran').attr('action', '{{ route('Pengeluaran.ubah_pengeluaran', '') }}/' +
                    id);

                // Menampilkan modal
                $('#modalPengeluaran').modal('show');
            });


            $('#formPengeluaran').submit(function(e) {
                var isValid = true;

                $('.validation-error').text(''); // Bersihkan pesan error sebelumnya

                var keterangan = $('#keterangan').val().trim();
                if (keterangan === '') {
                    $('#keterangan').next('.validation-error').text('Keterangan harus diisi.');
                    isValid = false;
                }

                var tgl_transaksi = $('#tgl_transaksi').val().trim();
                if (tgl_transaksi === '') {
                    $('#tgl_transaksi').next('.validation-error').text(
                        'Tanggal transaksi harus diisi.');
                    isValid = false;
                }

                var total_transaksi = $('#total_transaksi').val().trim();
                if (total_transaksi === '') {
                    $('#total_transaksi').next('.validation-error').text('Total pengeluaran harus diisi.');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault(); // Jangan submit form jika validasi gagal
                }
            });
        });
    </script>
@endsection
