@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Surat Ketarangan Sakit {{ $perusahaan->id }}

@stop
@section('page-title') 
<h2>Surat Ketarangan Sakit {{ $perusahaan->id }}</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li>
        <a href="{{ url('perusahaans/' . $perusahaan->id)}}">{{ $perusahaan->nama }}</a>
    </li>
    <li class="active">
        <strong>Surat Ketarangan Sakit {{ $perusahaan->id }}</strong>
    </li>
</ol>
@stop
@section('content') 
{{ $periksas->links() }}
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Pasien</th>
                <th>Pembayaran</th>
                <th>Dokter Pemeriksa</th>
                <th>Mulai SS</th>
                <th>Lama SS</th>
            </tr>
        </thead>
        <tbody>
            @if($periksas->count() > 0)
                @foreach($periksas as $periksa)
                    <tr>
                        <td nowrap>
                            <a href="{{ url('periksas/' . $periksa->id) }}" target="_blank">{{ $periksa->tanggal }}</a>
                        </td>
                        <td>
                            <a href="{{ url('pasiens/' . $periksa->pasien_id . '/edit') }}" target="_blank">{{ $periksa->pasien->nama }}</a>
                        </td>
                        <td>{{ $periksa->asuransi->nama }}</td>
                        <td>{{ $periksa->staf->nama }}</td>
                        <td>{{ !is_null($periksa->suratSakit)? $periksa->suratSakit->tanggal_mulai : '-' }}</td>
                        <td>{{ !is_null($periksa->suratSakit)? $periksa->suratSakit->hari . ' hari' : '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
                </tr>
            @endif
        </tbody>
    </table>
    <?php echo $periksas->appends(Input::except('page'))->links(); ?>
</div>
@stop
@section('footer') 
    
@stop
