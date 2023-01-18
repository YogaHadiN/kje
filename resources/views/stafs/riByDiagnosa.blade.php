@extends('layout.master')

@section('title') 
Klinik Jati Elok | Recovery Index By Diagnosa

@stop
@section('page-title') 
<h2>Recovery Index By Diagnosa</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Recovery Index By Diagnosa</strong>
            </li>
</ol>

@stop
@section('content') 
    <h1>Kegagalan Terapi {{ tambahkanGelar( $staf->titel->singkatan, $staf->nama ) }} untuk diagnosa {{ $data[0]->diagnosa }}</h1>
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Pasien</th>
                        <th>Diagnosa</th>
                        <th>Pembayaran</th>
                        <th>Current Condition</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data) > 0)
                        @foreach($data as $d)
                            <tr>
                                <td>
                                    <a href="{{ url('periksas/' . $d->periksa_id) }}" target="_blank">
                                        {{ $d->tanggal }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('pasiens/' . $d->pasien_id) }}" target="_blank">
                                        {{ $d->nama_pasien }}
                                    </a>
                                </td>
                                <td>{{ $d->diagnosa }}</td>
                                <td>{{ $d->pembayaran }}</td>
                                <td>{{ $d->keluhan }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">
                                Tidak ada data untuk ditampilkan
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
@stop
@section('footer') 
    
@stop
