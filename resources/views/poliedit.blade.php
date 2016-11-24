@extends('layout.master')

@section('title') 
Klinik Jati Elok | Poli {!! ucfirst($antrianperiksa->poli)!!} (Edit)
@stop
@section('head')
  <style>

    .padding {
      padding: 10px;
    }

    .panel-title {
      font-size: 24px;
    }
  </style>

@stop
@section('page-title') 

     <h2>RUANG PERIKSA Poli {!! ucfirst($antrianperiksa->poli)!!}</h2>
     <ol class="breadcrumb">
          <li>
              <a href="{!! url('laporans')!!}">Home</a>
          </li>
          <li>
              <a href="{!! url('ruangperiksa/' . $antrianperiksa->poli)!!}">Poli {!! ucfirst($antrianperiksa->poli) !!}</a>
          </li>
          <li class="active">
			  <strong>Periksa Edit</strong>
          </li>
    </ol>

@stop
@section('content') 

@include('before')
{!! Form::model($periksaex, [
	'url' => 'periksas/' . $periksaex->id, 
	'method' => 'put', 
	'files' => 'true', 
	'id' => 'submitPeriksa'
])!!}

@include('form', [
          'pemeriksaan_awal'             => $periksaex->pemeriksaan_fisik, 
          'transaksi'                    => $periksaex->transaksi, 
          'berat_badan'                  => $periksaex->berat_badan, 
          'terapiArray'                  => $trp,
          'presentasi'                   => $presentasi,
          'penunjang'                    => $penunjang,
          'adatindakan'                  => $adatindakan,
          'BPD_w'                        => $bpdw,
          'BPD_mm'                       => $bpd_mm,
          'HC_w'                        => $hcw,
          'HC_mm'                       => $hc_mm,
          'AC_mm'                        => $ac_mm,
          'FL_mm'                        => $fl_mm,
          'BPD_d'                        => $bpdd,
          'HC_d'                        => $hcd,
          'LTP'                          => $ltp,
          'FHR'                          => $djj,
          'AC_w'                         => $acw,
          'AC_d'                         => $acd,
          'EFW'                          => $efwd,
          'FL_w'                         => $flw,
          'FL_d'                         => $fld,
          'Sex'                          => $sex,
          'Plasenta'                     => $plasenta,
          'total_afi'                    => $ica,
          'kesimpulan'                   => $kesimpulan,
          'saran'                        => $saran,
          'uk'                           => $uk,
          'tb'                           => $tb,
          'jumlah_janin'                 => $jumlah_janin,
          'nama_suami'                   => $nama_suami,
          'bb_sebelum_hamil'             => $bb_sebelum_hamil,
          'golongan_darah'               => $golongan_darah,
          'rencana_penolong'             => $rencana_penolong,
          'rencana_tempat'               => $rencana_tempat,
          'rencana_pendamping'           => $rencana_pendamping,
          'rencana_transportasi'         => $rencana_transportasi,
          'rencana_pendonor'             => $rencana_pendonor,
          'td'                           => $td,
          'bb'                           => $bb,
          'tfu'                          => $tfu,
          'lila'                         => $lila,
          'djj'                          => $djj,
          'register_hamil_id'            => $register_hamil_id,
          'status_imunisasi_tt_id'       => $status_imunisasi_tt_id,
          'buku'                         => $buku_id,
          'refleks_patela'               => $refleks_patela_id,
          'kepala_terhadap_pap_id'       => $kepala_terhadap_pap_id,
          'presentasi_id'                => $presentasi_id,
          'catat_di_kia'                 => $catat_di_kia,
          'g'                            => $g,
          'p'                            => $p,
          'a'                            => $a,
          'pasien_id'                    => $periksaex->pasien_id,
          'gambarPeriksa'                    => $periksaex->gambarPeriksa,
          'riwayat_kehamilan_sebelumnya' => $riwayat_persalinan_sebelumnya,
          'hpht'                         => App\Classes\Yoga::updateDatePrep($hpht),
          'tanggal_lahir_anak_terakhir'  => App\Classes\Yoga::updateDatePrep($tanggal_lahir_anak_terakhir)
])
{!! Form::close()!!}

@if($periksaex->poli == 'estetika')
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	<img src="{!! url( 'qrcode?text=' . $url . '/periksa/' . $periksaex->id . '/images' ) !!}" alt="">
	</div>
</div>
@endif
@include('after')
@include('gambar_periksa')

@stop
@section('footer') 
<script>
    var base = '{!! url("/") !!}'
</script>
{!! HTML::script('js/allpoli.js')!!} 
{!! HTML::script('js/gambar_periksa.js')!!} 
@stop
