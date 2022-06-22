@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan DM Terkendali

@stop
@section('page-title') 
<h2>Laporan DM Terkendali</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Laporan DM Terkendali</strong>
    </li>
</ol>

@stop
@section('content') 
    <h2>{{ count($prolanis_dm) }} Pasien Prolanis DM Berobat Bulan Ini</h2>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Gula Darah</th>
            </tr>
        </thead>
        <tbody>
            @if(count($prolanis_dm) > 0)
                @foreach($prolanis_dm as $k => $d)
                    <tr
                        @if ( 
                            $d['gula_darah'] >= 80 
                            && $d['gula_darah'] <= 130  
                        )
                            class="success"
                        @elseif (
                            $d['gula_darah'] > 0 
                            && $d['gula_darah'] < 80
                        )
                            class="danger"
                        @endif
                    >
                        <td>{{ $k + 1 }}</td>
                        <td>
                            <a href="{{ url('periksas/' . $d['periksa_id'] ) }}" target="_blank">{{ $d['tanggal'] }}</a>
                        </td>
                        <td
							@if(is_null( $d['prolanis_dm_flagging_image'] ))
								class="danger"
							@endif
                        >
                            <a href="{{ url('pasiens/' . $d['pasien_id'] . '/edit') }}" target="_blank">{{ ucwords($d['nama']) }}</a>
                        </td>
                        <td>{{ $d['tanggal_lahir'] }}</td>
                        <td>{{ $d['alamat'] }}</td>
                        <td>{{ $d['gula_darah'] }}</td>
                        <td>
                            <a href="{{ url('pasiens/riwayat/gula_darah/' . $d['pasien_id'] )}}" target="_blank" class="btn btn-info btn-xs">Riwayat GDS</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@stop
@section('footer') 
    
@stop
