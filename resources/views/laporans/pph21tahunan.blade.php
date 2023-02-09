@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan PPh21 Tahunan

@stop
@section('page-title') 
<h2>Laporan PPh21 Tahunan</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Laporan PPh21 Tahunan</strong>
            </li>
</ol>

@stop
@section('content') 
        <div class="table-responsive">
            <table class="table table-condensed DTa">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Periode</th>
                        <th>Gaji Pokok</th>
                        <th>Pph21</th>
                        <th>Pph21 Terbaru</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($result) > 0)
                        @foreach($result as $r)
                            <tr @if($r['pph21_baru'] != $r['pph21'])  class="warning" @endif>
                                <td>{{ $r['nama'] }}</td>
                                <td>{{ $r['periode'] }}</td>
                                <td class="uang">{{ $r['gaji_bruto'] }}</td>
                                <td class="uang">{{ $r['pph21'] }}</td>
                                <td class="uang">{{ $r['pph21_baru'] }}</td>
                                <td class="uang">{{ $r['pph21_baru'] - $r['pph21'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        
@stop
@section('footer') 
    
@stop
