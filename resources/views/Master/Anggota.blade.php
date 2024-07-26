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
                @can('role-admin')
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary shadow-light mt-1 mb-3" data-bs-toggle="modal"
                            id="btnTambahAnggota">
                            Tambah Anggota
                            <i class="fas fa-plus-circle ps-1"></i>
                        </button>
                    </div>
                @endcan
                <div class="col-lg-12 mt-2">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-responsive table-light table-striped shadow-sm"
                            id="tabel_master-anggota">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Email</th>
                                    <th scope="col" class="text-center">Hubungan</th>
                                    <th scope="col" class="text-center">Tanggal Lahir</th>
                                    <th scope="col" class="text-center">No Telepon</th>
                                    <th scope="col" class="text-center">Role</th>
                                    @can('role-admin')
                                        <th scope="col" class="text-center">Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggota as $data)
                                    <tr>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->hubungan }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->tgl_lahir)->format('d-m-Y') }}</td>
                                        <td>{{ $data->no_telp }}</td>
                                        <td>{{ $data->role }}</td>
                                        @can('role-admin')
                                            <td class="text-center">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-warning shadow-warning mx-2 btnEditAnggota"
                                                    data-id="{{ $data->id }}" data-name="{{ $data->name }}"
                                                    data-hubungan="{{ $data->hubungan }}"
                                                    data-tgl_lahir="{{ \Carbon\Carbon::parse($data->tgl_lahir)->format('d-m-Y') }}"
                                                    data-email="{{ $data->email }}" data-no_telp="{{ $data->no_telp }}"
                                                    data-role="{{ $data->role }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ url('Anggota/hapus_anggota') }}/"
                                                    class="btn btn-danger shadow-danger tombol-hapus"
                                                    data-id="{{ $data->id }}"><i class="fas fa-trash-alt"></i></a>
                                                <form class="form-hapus" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </section>
    </div>

    <!-- Modal Tambah/Edit Anggota -->
    <div class="modal fade" id="modalAnggota" tabindex="-1" aria-labelledby="modalAnggotaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="formAnggota" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAnggotaLabel">Tambah Anggota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Tambah/Edit Anggota -->
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" autocomplete="off"
                                placeholder="Nama Anggota" required>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('E-Mail') }}</label>
                            <input id="email" type="email" class="form-control" name="email"
                                placeholder="email@gmail.com" autocomplete="off" required>
                            <small class="form-text text-danger validation-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                            <small class="form-text text-danger validation-error"></small>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="id_keluarga">{{ __('Keluarga') }}</label>
                            <select id="id_keluarga" class="form-control form-select" name="id_keluarga">
                                <option value="{{ Auth::user()->id_keluarga }}" selected>
                                    {{ __(Auth::user()->keluarga->nama_keluarga) }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hubungan">{{ __('Hubungan') }}</label>
                            <select class="form-control form-select" id="hubungan" name="hubungan" required>
                                <option value="SUAMI">Suami</option>
                                <option value="ISTRI">Istri</option>
                                <option value="ANAK">Anak</option>
                            </select>
                            <small class="form-text text-danger validation-error"></small>
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">{{ __('Tanggal Lahir') }}</label>
                            <div class="input-group flex-nowrap">
                                <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir"
                                    autocomplete="off" value="{{ date('d-m-Y') }}">
                                <span class="input-group-text">📅</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" autocomplete="off"
                                placeholder="628xxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label for="role">{{ __('Role') }}</label>
                            <select id="role" class="form-control form-select" name="role" required>
                                <option value="Anggota">{{ __('Anggota') }}</option>
                                <option value="Admin">{{ __('Admin') }}</option>
                            </select>
                        </div>
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
            $('#password').removeAttr('required');
            $('#password-confirm').removeAttr('required');

            // Mengambil data dari atribut data-*
            var id = $(this).data('id');
            var name = $(this).data('name');
            var hubungan = $(this).data('hubungan');
            var tgl_lahir = $(this).data('tgl_lahir');
            var email = $(this).data('email');
            var no_telp = $(this).data('no_telp');
            var role = $(this).data('role');

            // Mengisi form di dalam modal
            $('#modalAnggota').find('#name').val(name);
            $('#modalAnggota').find('#email').prop('disabled', true);
            $('#modalAnggota').find('#password').prop('disabled', true);
            $('#modalAnggota').find('#password-confirm').prop('disabled', true);
            $('#modalAnggota').find('#hubungan').val(hubungan);
            $('#modalAnggota').find('#tgl_lahir').val(tgl_lahir);
            $('#modalAnggota').find('#email').val(email);
            $('#modalAnggota').find('#no_telp').val(no_telp);
            $('#modalAnggota').find('#role').val(role);

            $('#modalAnggotaLabel').text('Edit Anggota');
            $('#formAnggota').attr('action',
                '{{ route('Anggota.ubah_anggota', '') }}/' + id);
            // Menampilkan modal
            $('#modalAnggota').modal('show');
        });


        $('#formAnggota').submit(function(e) {
            var isValid = true;

            $('.validation-error').text(''); // Bersihkan pesan error sebelumnya

            var name = $('#name').val().trim();
            if (name === '') {
                $('#name').next('.validation-error').text('Nama anggota harus diisi.');
                isValid = false;
            }

            var email = $('#email').val().trim();
            if (email === '') {
                $('#email').next('.validation-error').text('Email harus diisi.');
                isValid = false;
            }

            // var password = $('#password').val().trim();
            // if (password === '') {
            //     $('#password').next('.validation-error').text('Password harus diisi.');
            //     isValid = false;
            // }

            // var password_confirm = $('#password-confirm').val().trim();
            // if (password_confirm === '') {
            //     $('#password-confirm').next('.validation-error').text('Konfirmasi Password harus diisi.');
            //     isValid = false;
            // }

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
