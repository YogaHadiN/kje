@extends('layout.master')

@section('title') 
Klinik Jati Elok | Cek List Dikerjakan By Tanggal

@stop
@section('page-title') 
<h2>Cek List Dikerjakan By Tanggal</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cek List Dikerjakan By Tanggal</strong>
            </li>
</ol>

@stop
@section('content') 
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Ruangan</th>
                <th>Cek List</th>
                <th>jumlah</th>
                <th class="w-30-percent">Image</th>
            </tr>
        </thead>
        <tbody>
            @if($cek_list_dikerjakans->count() > 0)
                @foreach($cek_list_dikerjakans as $cek)
                    <tr 
                            @if( $cek->danger ) class='danger' @endif
                        >
                        <td>{{ $cek->created_at->format('d M Y') }}</td>
                        <td>{{ $cek->cekListRuangan->ruangan->nama }}</td>
                        <td>
                            <a href="{{ url('cek_list_dikerjakans/byCekListRuangan/' . $cek->cek_list_ruangan_id ) }}" target="_blank">
                                {{ $cek->cekListRuangan->cekList->cek_list }}
                            </a>
                        </td>
                        <td>{{ $cek->jumlah }}</td>
                        <td class="w-30-percent">
                            <p>
                                <a href="{{ \Storage::disk('s3')->url($cek->image) }}" target="_blank"> 
                                    <img src="{{ \Storage::disk('s3')->url($cek->image) }}" alt="" class="img-rounded upload"> 
                                </a>
                            </p>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">
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
