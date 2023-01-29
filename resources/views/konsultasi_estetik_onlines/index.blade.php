@extends('layout.master')

@section('title') 
Klinik Jati Elok | Konsultasi Estetik Online

@stop
@section('page-title') 
<h2>Konsultasi Estetik Online</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Konsultasi Estetik Online</strong>
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
                        <th>Keluhan Utama</th>
                        <th>Periode</th>
                        <th>Pengobatan Sebelumnya</th>
                        <th>Jenis Kulit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($konsultasi_estetik_onlines->count() > 0)
                        @foreach($konsultasi_estetik_onlines as $k)
                            <tr>
                                <td>{{ $k->created_at->format('d M Y') }}</td>
                                <td>{{ $k->nama }}</td>
                                <td>{{ $k->keluhan_utama }}</td>
                                <td>{{ $k->periode_keluhan_utama_id }}</td>
                                <td>{{ $k->pengobatan_sebelumnya }}</td>
                                <td>{{ $k->jenis_kulit_id }}</td>
                                <td nowrap class="autofit">
                                    <a href="{{ url('konsultasi_estetik_onlines/' . $k->id) }}" target="_blank">detil</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">

                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
@stop
@section('footer') 
    
@stop
