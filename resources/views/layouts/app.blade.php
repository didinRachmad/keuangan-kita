<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    {{-- CSS --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    {{-- SELECT2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-5-theme/1.3.0/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    {{-- DATATABLE --}}
    {{-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">

    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- FONTAWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />

    <style>
        html,
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            /* background-image: linear-gradient(to bottom, rgba(10, 10, 10, 0.3), rgba(10, 10, 10, 0.7)), url("https://source.unsplash.com/random/1366x768/?city,street"), url("../img/bg2.jpg"); */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .light {
            background-image: linear-gradient(to top, rgba(224, 224, 224, 0.8), rgba(224, 224, 224, 0.9)), url("../img/bg2.jpg");
            color: #000;
        }

        .dark {
            background-image: linear-gradient(to top, rgba(40, 46, 54, 0.9), rgba(40, 46, 54, 0.9)), url("../img/bg2.jpg");
            color: #fff;
        }

        .scroll::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #212529;
            border-radius: 10px;
        }

        .scroll::-webkit-scrollbar {
            width: 10px;
            background-color: #212529;
        }

        .scroll::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-image: -webkit-gradient(linear,
                    left bottom,
                    left top,
                    color-stop(0.44, rgb(174, 122, 217)),
                    color-stop(0.72, rgb(73, 90, 189)),
                    color-stop(0.86, rgb(28, 58, 148)));
        }

        .form-check-input[type="checkbox"]:hover {
            cursor: pointer;
        }

        #labelDarkModeToggle {
            font-size: 1.5em;
        }

        .form-switch .form-check-input {
            width: 30px;
            height: 15px;
        }

        .overlay {
            position: fixed;
            z-index: 999999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay i {
            font-size: 50px;
            color: #0e7b7f;
            animation: spin 1s infinite linear;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <style>
        @media print {
            .table {
                color: black;
                /* Warna teks */
            }

            .table th {
                background-color: #021020 !important;
                /* Background header */
                color: white !important;
                /* Warna teks header */
                -webkit-print-color-adjust: exact;
            }

            .table td {
                background-color: #E3F2FD !important;
                /* Background sel */
                -webkit-print-color-adjust: exact;
            }
        }
    </style>

    <script>
        if (localStorage.getItem("darkMode") === "enabled") {
            document.write(`<style>.overlay { background-color: #021020;}
            .bg-btn { box-shadow: -1px 3px 4px rgb(167, 192, 205); }
            .card { background-color: rgba(2, 16, 32, 0.9); }
            .main-sidebar { background-color: #021020; }
            .navbar-nav li a::after { background-color: #FFF; color: #000; }
            </style>`);

        } else {
            document.write(`<style>.overlay { background-color: #f2f2f2; }
            .bg-btn { box-shadow: -1px 3px 4px rgb(245, 242, 207); }
            .card { background-color: #fff; }
            .main-sidebar { background-color: #fff; }
            .navbar-nav li a::after { background-color: #021020; color: #fff; }
            </style>`);
        }
    </script>
</head>

{{-- LOADING OVERLAY --}}
<div class="overlay">
    <i class="fa-brands fa-instalod"></i>
</div>

<body class="scroll dark">

    <div class="navbar-bg"></div>
    <nav class="navbar main-navbar">
        <ul class="navbar-nav ps-3">
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i>
                <h5 class="mt-2 text-light d-inline ml-3">{{ $title }}</h5>
            </a>
        </ul>
        <ul class="navbar-nav ms-auto pe-4 d-flex align-items-center">
            <li class="nav-item d-flex align-items-center text-white">
                <div id="labelDarkModeToggle"></div>
                <div class="form-check form-switch form-check-lg mx-3">
                    <input class="form-check-input" type="checkbox" id="darkModeToggle">
                </div>
                <div class="dropdown d-inline-block user-dropdown ms-3">
                    <button type="button" class="btn btn-outline-light" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fas fa-user-circle fs-4"></i>
                        <span class="d-none d-xl-inline-block px-1 fs-5 fw-bold">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="position: absolute;">
                        @guest
                            <a class="nav-link" href="{{ route('login') }}"><span>{{ __('Login') }}</span></a>
                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}"><span>{{ __('Register') }}</span></a>
                            @endif
                        @else
                            <a class="nav-link text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt pe-3"></i> <span>{{ __('Logout') }}</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endguest
                    </div>
                </div>
                {{-- <span class="d-none d-md-inline fs-5 me-2">{{ Auth::user()->name }}</span>
                <i class="fas fa-user-circle fs-4"></i> --}}
            </li>
        </ul>
    </nav>

    </div>
    <div class="main-sidebar">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="{{ url('dashboard') }}" class="text-primary fw-bold" style="font-size: 16px;"><i
                        class="fas fa-book-open"></i> Keuangan Kita</a>
                @if (strlen(Auth::user()->nama_keluarga) > 25)
                    <p class="text-primary fw-bold"><span class="badge badge-primary"> <i class="fas fa-home"></i>
                            {{ substr(Auth::user()->nama_keluarga, 0, 23) . '..' }}</span></p>
                @else
                    <p class="text-primary fw-bold"><span class="badge badge-primary"> <i class="fas fa-home"></i>
                            {{ Auth::user()->nama_keluarga }}</span></p>
                @endif
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header mt-4">Dashboard</li>
                <li class="{{ request()->routeIs('Dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('dashboard') }}">
                        <i class="fas fa-fire"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Tambahkan kategori dan produk sesuai kebutuhan -->

                <li class="menu-header">Master</li>
                <li class="{{ request()->routeIs('Akun.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/Akun') }}">
                        <i class="fas fa-cash-register"></i>
                        <span>Akun</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('Kategori.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/Kategori') }}">
                        <i class="fas fa-layer-group"></i>
                        <span>Kategori</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('Anggota.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/Anggota') }}">
                        <i class="fas fa-users"></i>
                        <span>Anggota</span>
                    </a>
                </li>
                <li class="menu-header">Transaksi</li>
                <li class="{{ request()->routeIs('Pengeluaran.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/Pengeluaran') }}">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                        <span>Pengeluaran</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('Pemasukan.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/Pemasukan') }}">
                        <i class="fas fa-arrow-alt-circle-right"></i>
                        <span>Pemasukan</span>
                    </a>
                </li>

                <li class="menu-header">Profil</li>
                <li class="{{ request()->routeIs('profil.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('profil') }}">
                        <i class="fas fa-house-user"></i>
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
        </aside>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keuangan Kita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Anda Yakin Keluar Dari Keuangan Kita ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a class="btn btn-danger" href="{{ url('auth/logout') }}">Keluar</a>
                </div>
            </div>
        </div>
    </div>




    {{-- <nav id="sidebar">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="logo py-3" src="{{ asset('img/logo.ico') }}" alt="Logo">
            {{ config('app.name', 'Laravel') }}
        </a>
        <br>
        <br>
        <br>
        <ul class="navbar-nav mt-3">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item">
                    <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Logout"
                        href="{{ route('logout') }}"><i class="bi bi-box-arrow-in-left"></i></a>
                </li>
            @endguest
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Kode Customer"
                    href="{{ route('KodeCustomer.index') }}"><i class="bi bi-qr-code"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Tool Outlet"
                    href="{{ route('ToolOutlet.index') }}"><i class="bi bi-gear-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="List Rute"
                    href="{{ route('ListRute.index') }}"><i class="bi bi-signpost-split-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Tool Depo"
                    href="{{ route('ToolDepo.index') }}"><i class="bi bi-house-gear-fill"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Tool Excel"
                    href="{{ route('ToolExcel.index') }}"><i class="bi bi-file-earmark-arrow-up"></i></a>
            </li>
            <li class="nav-item py-3">
                <a class="btn btn-sm btn-block bg-btn p-2 btn-dark fw-bold" data-tooltip="Exec Rekap"
                    href="{{ route('ExecRekap.index') }}"><i class="bi bi-ui-checks"></i></a>
            </li>
            <li class="nav-item pt-3 mx-auto">
                <div class="form-check form-switch form-check-lg m-0 p-0">
                    <input class="form-check-input" type="checkbox" id="darkModeToggle">
                </div>
            </li>
            <li class="nav-item">
                <div id="labelDarkModeToggle"></div>
            </li>
        </ul>
    </nav> --}}
    <div id="app">
        <div class="main-wrapper pb-5">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/myjs.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.42/moment-timezone-with-data.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // $("input[type='text'], input[type='search']").on('paste', function(event) {
            //     event.preventDefault();
            //     var pastedValue = event.originalEvent.clipboardData.getData('text/plain');
            //     $(this).val(pastedValue.toUpperCase());
            // });


            const darkModeToggle = $("#darkModeToggle");
            // Set initial dark mode based on user preference (you can use local storage)
            if (localStorage.getItem("darkMode") === "enabled") {
                darkModeToggle.prop("checked", true);
                $("body").addClass('dark');
                $("body").removeClass('light');
                $("table").addClass("table-dark");
                $("table").removeClass("table-light");
                $(".main-sidebar").css('background-color', "#021020");
                $('#labelDarkModeToggle').html('<i class="fa fa-moon text-info"></i>');
            } else {
                darkModeToggle.prop("checked", false);
                $("body").addClass('light');
                $("body").removeClass('dark');
                $("table").removeClass("table-dark");
                $("table").addClass("table-light");
                $(".main-sidebar").css('background-color', "#fff");
                $('#labelDarkModeToggle').html('<i class="fa fa-sun text-warning"></i>');
            }

            darkModeToggle.on("change", function() {
                if (darkModeToggle.prop("checked")) {
                    $("body").addClass('dark');
                    $("body").removeClass('light');
                    $(".bg-btn").css('box-shadow', '-1px 3px 4px rgb(167, 192, 205)');
                    $(".card").css('background-color', "rgba(2, 16, 32, 0.9)");
                    $(".main-sidebar").css('background-color', "#252B3B");
                    $(".navbar-nav li a::after").css({
                        'background-color': '#252B3B',
                        'color': '#fff'
                    });
                    $("table").addClass("table-dark");
                    $("table").removeClass("table-light");
                    $('#labelDarkModeToggle').html('<i class="fa fa-moon text-info"></i>');
                    localStorage.setItem("darkMode", "enabled");
                } else {
                    $("body").addClass('light');
                    $("body").removeClass('dark');
                    $(".bg-btn").css('box-shadow', '-1px 3px 4px rgb(245, 242, 207)');
                    $(".card").css('background-color', "#fff");
                    $(".main-sidebar").css('background-color', "#fff");
                    $(".navbar-nav li a::after").css({
                        'background-color': '#fff',
                        'color': '#000'
                    });
                    $("table").removeClass("table-dark");
                    $("table").addClass("table-light");
                    $('#labelDarkModeToggle').html('<i class="fa fa-sun text-warning"></i>');
                    localStorage.setItem("darkMode", "disabled");
                }
            });

            $('.overlay').fadeOut(200);
        });
    </script>
</body>

</html>
