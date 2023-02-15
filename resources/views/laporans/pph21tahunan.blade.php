@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan PPh21 Tahunan

@stop
@section('page-title') 
    <h2>Laporan PPh21 Tahunan {{ $staf->nama }}</h2>
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
    <h3>{{ $staf->nama }}</h3>
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Gaji Bruto</th>
                        <th>Gaji Netto</th>
                        <th>Pph21</th>
                        <th>Pph21 baru</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($result) > 0)
                        @php
                            $selisih_pph = 0;
                        @endphp
                        @foreach($result as $r)
                            <tr>
                                <td>{{ $r->periode }}</td>
                                <td class="uang">{{ buatrp($r->gaji_pokok + $r->bonus) }}</td>
                                <td class="uang">{{ buatrp($r->gaji_pokok + $r->bonus - $r->pph) }}</td>
                                <td class="uang">{{ buatrp($r->pph) }}</td>
                                @php
                                    $pph21Baru = pph21BulanIni( $r->gaji_pokok + $r->bonus, $r->staf_id );
                                    $selisih = $pph21Baru - $r->pph;
                                    $selisih_pph += $selisih;
                                @endphp
                                <td class="uang">{{ buatrp($pph21Baru) }}</td>
                                <td class="uang">{{ buatrp($selisih) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data untuk Ditampilkan</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"></th>
                        <th class="uang">{{ buatrp( $selisih_pph ) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        

@stop
@section('footer') 
@stop
