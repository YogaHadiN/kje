@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Dispensing Obat {{ $data[0]->nama_staf }} 

@stop
@section('page-title') 
<h2>Dispensing Obat {{ $data[0]->nama_staf }}</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li>
        <a href="{{ url('laporans/bpjs/dispensing_obat')}}">
            Dispensing Obat Bpjs
        </a>
    </li>
    <li class="active">
            <strong>Dispensing Obat {{ $data[0]->nama_staf }}</strong>
    </li>
</ol>

@stop
@section('content') 
    <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Dispensing</th>
                    <th>Jumlah Pasien</th>
                    <th>Rata-rata/psn</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{{ $d->tanggal }}</td>
                        <td>{{ $d->nama_staf }}</td>
                        <td class="uang text-right">{{ $d->hpp }}</td>
                        <td class="text-right">{{ $d->jumlah_pasien }}</td>
                        <td class="uang text-right">{{ ceil( $d->hpp / $d->jumlah_pasien ) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
@section('footer') 
    
@stop
