@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Tindakan Harian

@stop
@section('page-title') 
<h2>Laporan Tindakan Harian</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Laporan Tindakan Harian</strong>
            </li>
</ol>

@stop
@section('content') 
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Jenis Tarif</th>
                        <th>Jumlah</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_biaya = 0;
                    @endphp
                    @if(count($data))
                        @foreach($data as $k => $d)
                            @php
                                $total_biaya += $d['biaya'];
                            @endphp
                            @if( $d )
                            <tr>
                                <td>{{ $k }}</td>
                                <td class="text-right">{{ $d['jumlah'] }}</td>
                                <td class="uang">{{ $d['biaya'] }}</td>
                            </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center">Tidak ada data untuk Ditampilkan</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total Pemasukan</th>
                        <th class="uang">
                            {{ $total_biaya }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
@stop
@section('footer') 
    
@stop
