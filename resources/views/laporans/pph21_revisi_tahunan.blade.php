@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Revisi Tahunan {{ $tahun }}

@stop
@section('page-title') 
<h2>Laporan Revisi Tahunan {{ $tahun }}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Laporan Revisi Tahunan {{ $tahun }}</strong>
            </li>
</ol>

@stop
@section('content') 
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Gaji Pokok</th>
                        <th>Total Bonus</th>
                        <th>Total Gaji Bruto</th>
                        <th>Total Gaji Netto</th>
                        <th>Pph21</th>
                        <th>Pph21 Revisi</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data) > 0)
                        @foreach($data as $k => $d)
                            <tr>
                                <td>
                                    <a href="{{ url('laporans/pph21/tahunan?submit=submit&staf_id=' .$k. '&tahun=' . $tahun) }}" target="_blank">{{ $d['nama'] }}</a>
                                </td>
                                <td>{{ buatrp(  $d['gaji_pokok']  ) }}</td>
                                <td>{{ buatrp(  $d['bonus']  ) }}</td>
                                <td>{{ buatrp( $d['gaji_pokok'] + $d['bonus']  ) }}</td>
                                <td>{{ buatrp( $d['gaji_pokok'] + $d['bonus'] - $d['pph'] ) }}</td>
                                <td>{{ buatrp( $d['pph'] ) }}</td>
                                <td>{{ buatrp( $d['pph_revisi'] ) }}</td>
                                <td>{{ buatrp( $d['pph_revisi'] -  $d['pph']  ) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data untuk ditampilkan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
@stop
@section('footer') 
    
@stop
