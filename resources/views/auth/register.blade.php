@extends('layouts.authLayout')

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold text-center">{{ __('Daftar') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name">{{ __('Nama') }}</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('E-Mail') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group">
                                <label for="id_keluarga">{{ __('Keluarga') }}</label>
                                <select id="id_keluarga"
                                    class="form-control form-select @error('id_keluarga') is-invalid @enderror"
                                    name="id_keluarga">
                                    <option value="">{{ __('Pilih Keluarga') }}</option>
                                    @foreach ($keluargas as $keluarga)
                                        <option value="{{ $keluarga->id }}">{{ $keluarga->nama_keluarga }}</option>
                                    @endforeach
                                </select>
                                @error('id_keluarga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="hubungan">{{ __('Hubungan') }}</label>
                                <select id="hubungan"
                                    class="form-control form-select @error('hubungan') is-invalid @enderror"
                                    name="hubungan">
                                    <option value="SUAMI">Suami</option>
                                    <option value="ISTRI">Istri</option>
                                    <option value="ANAK">Anak</option>
                                </select>
                                @error('hubungan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tgl_lahir">{{ __('Tanggal Lahir') }}</label>
                                <input id="tgl_lahir" type="date"
                                    class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir">
                                @error('tgl_lahir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="no_telp">{{ __('No Telpon') }}</label>
                                <input id="no_telp" type="text"
                                    class="form-control @error('no_telp') is-invalid @enderror" name="no_telp">
                                @error('no_telp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="role">{{ __('Role') }}</label>
                                <select id="role" class="form-control @error('role') is-invalid @enderror"
                                    name="role" required>
                                    <option value="keluarga_keluarga">{{ __('Anggota') }}</option>
                                    <option value="Admin">{{ __('Admin') }}</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary shadow-light">
                                    {{ __('Register') }}
                                </button>

                                <a class="btn btn-danger shadow-danger" href="{{ route('login') }}">
                                    {{ __('Kembali') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container-login100">
        <div class="row wrap-login100">
            <div class="col-sm-12">
                <span class="login100-form-title">
                    {{ __('Login') }}
                </span>
            </div>
            <div class="col-sm-12">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">{{ __('Nama') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('E-Mail') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="id_keluarga">{{ __('Keluarga') }}</label>
                        <select id="id_keluarga" class="form-control form-select @error('id_keluarga') is-invalid @enderror"
                            name="id_keluarga">
                            <option value="">{{ __('Pilih Keluarga') }}</option>
                            @foreach ($keluargas as $keluarga)
                                <option value="{{ $keluarga->id }}">{{ $keluarga->nama_keluarga }}</option>
                            @endforeach
                        </select>
                        @error('id_keluarga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hubungan">{{ __('Hubungan') }}</label>
                        <select id="hubungan" class="form-control form-select @error('hubungan') is-invalid @enderror"
                            name="hubungan">
                            <option value="SUAMI">Suami</option>
                            <option value="ISTRI">Istri</option>
                            <option value="ANAK">Anak</option>
                        </select>
                        @error('hubungan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tgl_lahir">{{ __('Tanggal Lahir') }}</label>
                        <input id="tgl_lahir" type="text"
                            class="form-control datepicker @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir"
                            placeholder="dd-mm-yyyy">
                        @error('tgl_lahir')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="no_telp">{{ __('No Telpon') }}</label>
                        <input id="no_telp" type="text" class="form-control @error('no_telp') is-invalid @enderror"
                            name="no_telp">
                        @error('no_telp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">{{ __('Role') }}</label>
                        <select id="role" class="form-control @error('role') is-invalid @enderror" name="role"
                            required>
                            <option value="keluarga_keluarga">{{ __('Anggota') }}</option>
                            <option value="Admin">{{ __('Admin') }}</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary shadow-light">
                            {{ __('Register') }}
                        </button>

                        <a class="btn btn-danger shadow-danger" href="{{ route('login') }}">
                            {{ __('Kembali') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
