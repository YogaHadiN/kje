@extends('layout.master')

@section('title') 
Klinik Jati Elok | Satisfaction Index 

@stop
@section('page-title') 
<h2>Satisfaction Index </h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Satisfaction Index </strong>
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
                <th>Pemeriksa</th>
                <th>Complain</th>
            </tr>
        </thead>
        <tbody>
            @if(count($antrians) > 0)
                @foreach($antrians as $antrian)
                    <tr>
                        <td nowrap>
                            <a href="{{ url('periksas/' . $antrian->antriable_id) }}" target="_blank">
                                {{ $antrian->tanggal }}
                            </a>
                        </td>
                        <td nowrap>
                            <a href="{{ url('pasiens/' . $antrian->pasien_id . '/edit') }}" target="_blank">
                                {{ ucwords( $antrian->nama_pasien ) }}
                            </a>
                        </td>
                        <td nowrap>{{ $antrian->nama_asuransi }}</td>
                        <td nowrap>{{ $antrian->nama_staf }}</td>
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
