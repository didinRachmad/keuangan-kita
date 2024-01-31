@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="font-size: 12px;">Total Debit - <span
                                        class="text-primary">{{ $bulan }}</span></h4>
                            </div>
                            <div class="card-body">
                                {{ number_format($total_debit, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary text-light fw-bold">
                            Rp.
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="font-size: 12px;">Total Kredit - <span
                                        class="text-primary">{{ $bulan }}</span></h4>
                            </div>
                            <div class="card-body">
                                {{ number_format($total_kredit, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fa-solid fa-wallet text-white"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 style="font-size: 12px;">Total Saldo - <span
                                        class="text-primary">{{ date('Y') }}</span></h4>
                            </div>
                            <div class="card-body">
                                {{ number_format($total_saldo, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
