@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Laporan ppH21 bulan {{ $bulanTahun->format('F Y') }}

@stop
@section('page-title') 
<h2>Laporan ppH21 bulan {{ $bulanTahun->format('F Y') }}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Laporan ppH21 bulan {{ $bulanTahun->format('F Y') }}</strong>
            </li>
</ol>

@stop
@section('content') 
    <h1> Laporan pph21 untuk pelaporan per bulan </h1>
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NPWP</th>
                        <th>Jenis Kelamin</th>
                        <th>Menikah</th>
                        <th>Jumlah Anak</th>
                        <th>Total Gaji</th>
                        <th>potongan 5%</th>
                        <th>potongan 15%</th>
                        <th>potongan 25%</th>
                        <th>potongan 30%</th>
                    </tr>
                </thead>
                <tbody>
                    @if($bayar_gajis->count() > 0 && count($bayar_dokters) > 0)
                        @foreach($bayar_gajis as $gaji)
                            <tr>
                                <td>{{ $gaji->staf->nama }}</td>
                                <td>{{ $gaji->staf->npwp }}</td>
                                <td>{{ $gaji->staf->jenis_kelamin }}</td>
                                <td>{{ $gaji->menikah }}</td>
                                <td>{{ $gaji->jumlah_anak }}</td>
                                <td class="uang">{{ $gaji->gaji_pokok + $gaji->bonus }}</td>
                                <td class="uang">{{ $gaji->potongan5persen }}</td>
                                <td class="uang">{{ $gaji->potongan15persen }}</td>
                                <td class="uang">{{ $gaji->potongan25persen }}</td>
                                <td class="uang">{{ $gaji->potongan30persen }}</td>
                            </tr>
                        @endforeach
                        @foreach($bayar_dokters as $gaji)
                            <tr>
                                <td>{{ $gaji->nama }}</td>
                                <td>{{ $gaji->npwp }}</td>
                                <td>{{ $gaji->jenis_kelamin }}</td>
                                <td>{{ $gaji->menikah }}</td>
                                <td>{{ $gaji->jumlah_anak }}</td>
                                <td class="uang">{{ $gaji->bayar_dokter }}</td>
                                <td class="uang">{{ $gaji->potongan5persen }}</td>
                                <td class="uang">{{ $gaji->potongan15persen }}</td>
                                <td class="uang">{{ $gaji->potongan25persen }}</td>
                                <td class="uang">{{ $gaji->potongan30persen }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data untuk ditampilkan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
@stop
@section('footer') 
    
@stop
