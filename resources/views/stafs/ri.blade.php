@extends('layout.master')

@section('title') 
Klinik Jati Elok | Recovery Index

@stop
@section('page-title') 
<h2>Recovery Index</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Recovery Index</strong>
    </li>
</ol>

@stop
@section('content') 
    <h1>Laporan Kegagalan Terapi {{ $staf->nama }} Menurut Diagnosa</h1>
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Diagnosa</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data) > 0)
                        @foreach($data as $d)
                            <tr>
                                <td>
                                    <a href="{{  url('stafs/' . $staf->id . '/recovery_index/by_diagnosa/' . $d->diagnosa_id) }}" target="_blank">
                                        {{ $d->diagnosa }}
                                    </a>
                                </td>
                                <td>{{ $d->jumlah }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-center">
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
