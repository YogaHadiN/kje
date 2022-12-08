@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Kepuasan Bulanan

@stop
@section('page-title') 
<h2>Laporan Kepuasan Bulanan</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Laporan Kepuasan Bulanan</strong>
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
                <th>Pembayaran</th>
                <th>Complain</th>
            </tr>
        </thead>
        <tbody>
            @if($antrians->count() > 0)
                @foreach($antrians as $antrian)
                    <tr>
                        <td>
                            <a href="{{ url('periksas/' . $antrian->antriable_id) }}" target="_blank">
                                {{ $antrian->created_at->format('d M Y') }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ url('pasiens/' . $antrian->antriable->pasien_id . '/edit') }}" target="_blank">
                                {{ ucwords( $antrian->antriable->pasien->nama ) }}
                            </a>
                        </td>
                        <td>{{ $antrian->antriable->asuransi->nama }}</td>
                        <td>{{ $antrian->complaint }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@stop
@section('footer') 
    
@stop
