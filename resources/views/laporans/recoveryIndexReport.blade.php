@extends('layout.master')

@section('title') 
Klinik Jati Elok | Lapora Recovery Index

@stop
@section('page-title') 
<h2>Lapora Recovery Index</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Lapora Recovery Index</strong>
    </li>
</ol>

@stop
@section('content') 
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Dokter</th>
                <th>Pembayaran</th>
                <th>Current Condition</th>
            </tr>
        </thead>
        <tbody>
            @if($antrians->count() > 0)
                @foreach($antrians as $antrian)
                    <tr>
                        <td>
                            <a href="{{ url('periksas/' . $antrian->antriable->id) }}" target="_blank">
                                {{ $antrian->created_at->format('d M Y') }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ url('pasiens/' . $antrian->antriable->id . '/edit') }}" target="_blank">
                                {{ ucwords($antrian->antriable->pasien->nama) }}
                            </a>
                        </td>
                        <td>{{ ucwords($antrian->antriable->staf->nama) }}</td>
                        <td>{{ $antrian->antriable->asuransi->nama }}</td>
                        <td>{{ $antrian->informasi_terapi_gagal }}</td>
                        {{-- <td>{{ $antrian->informa }}</td> --}}
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">Tidak ada data untuk Ditampilkan</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@stop
@section('footer') 
    
@stop
