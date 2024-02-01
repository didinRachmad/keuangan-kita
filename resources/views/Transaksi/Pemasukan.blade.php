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
                            <button type="button" class="btn btn-primary mt-1 mb-3" data-bs-toggle="modal"
                                id="btnTambahPemasukan">
                                Tambah Pemasukan
                            </button>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ url('Pemasukan/cari_pemasukan') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <select class="form-control form-select" id="bulan" name="bulan">
                                            @php
                                                $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
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
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered table-responsive table-light table-striped shadow-sm"
                        id="tabel-keuangan" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Keterangan</th>
                                <th scope="col" width="15%" class="text-center">Tanggal Transaksi</th>
                                <th scope="col" width="15%" class="text-center">Total Transaksi (Rp)</th>
                                <th scope="col" width="15%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemasukan as $data)
                                <tr>
                                    <td class="text-capitalize keterangan">{{ $data->keterangan }}</td>
                                    <td class="text-center tanggal_transaksi">
                                        {{ \Carbon\Carbon::parse($data->tanggal_transaksi)->format('d-m-Y') }}</td>
                                    <td class="text-center fw-bolder total_transaksi">
                                        {{ number_format($data->total_transaksi, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-warning mx-2 btnEditPemasukan"
                                            data-id="{{ $data->id }}" data-keterangan="{{ $data->keterangan }}"
                                            data-tanggal_transaksi="{{ \Carbon\Carbon::parse($data->tanggal_transaksi)->format('d-m-Y') }}"
                                            data-total_transaksi="{{ number_format($data->total_transaksi, 0, ',', '.') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ url('Pemasukan/hapus_pemasukan') }}/"
                                            class="btn btn-danger tombol-hapus" data-id="{{ $data->id }}"><i
                                                class="fas fa-trash-alt"></i></a>
                                        <form id="form-hapus" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="text-center fw-bold">
                                <td colspan="2" class="text-center">Total:</td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </section>
    </div>

    <!-- Modal Tambah/Edit Pemasukan -->
    <div class="modal fade" id="modalPemasukan" tabindex="-1" aria-labelledby="modalPemasukanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPemasukanLabel">Tambah Pemasukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah/Edit Pemasukan -->
                    <form method="POST" id="formPemasukan" action="">
                        @csrf
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" autocomplete="off">
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_transaksi">Tanggal</label>
                            <input class="form-control datepicker" id="tanggal_transaksi" name="tanggal_transaksi"
                                autocomplete="off">
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="total_transaksi">Total Pemasukan (Rp)</label>
                            <input type="text" class="form-control uang" id="total_transaksi" name="total_transaksi"
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
        $('#btnTambahPemasukan').click(function() {
            $('.validation-error').text('');
            $('#modalPemasukanLabel').text('Tambah Pemasukan');
            $('#formPemasukan').attr('action', '{{ route('Pemasukan.tambah_pemasukan') }}');
            document.getElementById('formPemasukan').reset();
            $('#pemasukanId').val('');
            $('#modalPemasukan').modal('show');
        });

        $('.btnEditPemasukan').click(function() {
            $('.validation-error').text('');

            // Mengambil data dari atribut data-*
            var id = $(this).data('id');
            var keterangan = $(this).data('keterangan');
            var tanggal_transaksi = $(this).data('tanggal_transaksi');
            var total_transaksi = $(this).data('total_transaksi');

            // Mengisi form di dalam modal
            $('#modalPemasukan').find('#keterangan').val(keterangan);
            $('#modalPemasukan').find('#tanggal_transaksi').val(tanggal_transaksi);
            $('#modalPemasukan').find('#total_transaksi').val(total_transaksi);

            $('#modalPemasukanLabel').text('Edit Pemasukan');
            $('#formPemasukan').attr('action', '{{ route('Pemasukan.ubah_pemasukan', '') }}/' + id);

            // Menampilkan modal
            $('#modalPemasukan').modal('show');
        });


        $('#formPemasukan').submit(function(e) {
            var isValid = true;

            $('.validation-error').text(''); // Bersihkan pesan error sebelumnya

            var keterangan = $('#keterangan').val().trim();
            if (keterangan === '') {
                $('#keterangan').next('.validation-error').text('Keterangan harus diisi.');
                isValid = false;
            }

            var tanggal_transaksi = $('#tanggal_transaksi').val().trim();
            if (tanggal_transaksi === '') {
                $('#tanggal_transaksi').next('.validation-error').text('Tanggal transaksi harus diisi.');
                isValid = false;
            }

            var total_transaksi = $('#total_transaksi').val().trim();
            if (total_transaksi === '') {
                $('#total_transaksi').next('.validation-error').text('Total pemasukan harus diisi.');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault(); // Jangan submit form jika validasi gagal
            }
        });
    </script>
@endsection
