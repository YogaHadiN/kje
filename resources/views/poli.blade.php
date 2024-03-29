@extends('layout.master')

@section('title') 
    {{ ucwords( \Auth::user()->tenant->name ) }} | Poli {!! ucfirst($antrianperiksa->poli->poli)!!}
@stop
@section('head')
    {{-- <link href="{!! asset('css/poli.css') !!}" rel="stylesheet"> --}}
    <style type="text/css" media="screen">
.carousel-indicators li {
    display: inline-block;
    width: 10px;
    height: 10px;
    margin: 5px;
    text-indent: 0;
    cursor: pointer;
    border: none;
    border-radius: 50%;
    background-color: #B0B0B0;
    box-shadow: inset 1px 1px 1px 1px rgba(0,0,0,0.5);    
}
.carousel-indicators .active {
    width: 10px;
    height: 10px;
    margin: 5px;
    background-color: #DCDCDC;
}
    </style>
@stop
@section('page-title') 
    <h2>RUANG PERIKSA {!! ucfirst($antrianperiksa->poli->poli)!!}</h2>
     <ol class="breadcrumb">
          <li>
              <a href="{!! url('laporans')!!}">Home</a>
          </li>
          <li>
              <a href="{!! url('ruangperiksa/' . $antrianperiksa->poli_id)!!}">{!! ucfirst($antrianperiksa->poli->poli) !!}</a>
          </li>
          <li class="active">
              <strong>Ruang Periksa</strong>
          </li>
    </ol>
@stop
@section('content') 
	@include('before') 
	{!! Form::open([
		'url'			=> 'periksas', 
		'method'		=> 'post', 
		'id'			=> 'submitPeriksa', 
		'files'			=> 'true', 
		'autocomplete'	=> 'on'
	])!!}
      @include('form', [
          'pemeriksaan_awal'             => $pemeriksaan_awal,
          'transaksi'                    => $transaksiusg,
          'berat_badan'                  => $antrianperiksa->berat_badan,
          'sudah'                        => $sudah,
		  'sistolik'                     => $antrianperiksa->sistolik,
		  'diastolik'                    => $antrianperiksa->diastolik,
          'adatindakan'                  => $adatindakan,
          'penunjang'                    => $penunjang,
          'terapiArray'                  => '[]',
          'presentasi'                   => 'kepala tunggal hidup intrauterine',
          'BPD_w'                        => null,
          'BPD_mm'                       => null,
          'HC_w'                         => null,
          'HC_mm'                        => null,
          'AC_mm'                        => null,
          'FL_mm'                        => null,
          'BPD_d'                        => null,
          'HC_d'                         => null,
          'LTP'                          => null,
          'FHR'                          => null,
          'AC_w'                         => null,
          'AC_d'                         => null,
          'EFW'                          => null,
          'FL_w'                         => null,
          'FL_d'                         => null,
          'Sex'                          => null,
          'Plasenta'                     => 'fundus grade 2 -3 tidak menutupi jalan lahir',
          'total_afi'                    => null,
          'kesimpulan'                   => null,
          'saran'                        => 'periksa hamil 4 minggu lagi',
          'uk'                           => null,
          'tb'                           => $antrianperiksa->tinggi_badan,
          'jumlah_janin'                 => null,
          'nama_suami'                   => null,
          'bb_sebelum_hamil'             => null,
          'tanggal_lahir_anak_terakhir'  => null,
          'golongan_darah'               => null,
          'rencana_penolong'             => null,
          'rencana_tempat'               => null,
          'rencana_pendamping'           => null,
          'rencana_transportasi'         => null,
          'rencana_pendonor'             => null,
          'g'                            => $antrianperiksa->g,
          'p'                            => $antrianperiksa->p,
          'a'                            => $antrianperiksa->a,
          'td'                           => $antrianperiksa->tekanan_darah,
          'perujuk_id'                   => $antrianperiksa->perujuk_id,
          'bb'                           => $antrianperiksa->berat_badan,
          'tfu'                          => null,
          'lila'                         => null,
          'djj'                          => null,
          'register_hamil_id'            => null,
          'pasien_id'                    => null,
          'status_imunisasi_tt_id'       => '1',
          'buku'                         => '3',
          'refleks_patela'               => '6',
          'kepala_terhadap_pap_id'       => '7',
          'presentasi_id'                => '2',
          'riwayat_kehamilan_sebelumnya' => '[]',
          'catat_di_kia'                 => '1',
          'hpht'                         => App\Models\Classes\Yoga::updateDatePrep($antrianperiksa->hpht)
      ])
{!! Form::close()!!}
@include('after', ['cekGdsBulanIni' => $cekGdsBulanIni])
@include('gambar_periksa')
@stop
@section('footer') 
@if( isset($panggilan) )
	{!! Form::text('audio', json_encode($panggilan), ['class' => 'form-control hide', 'id' => 'sound']) !!}
	@include('panggil')
@endif
<script>
var base  = '{!! url('/') !!}';
var base_s3_wa = "{{ env('AWS_URL') }}";
console.log( 'base_s3_wa', base_s3_wa );
</script>
{!! HTML::script('js/gambar_periksa.js')!!} 
<script src="{!! asset('js/panggil.js') !!}"></script>
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
{!! HTML::script('js/allpoli.js?ver=23')!!} 
{!! HTML::script('js/alergi.js')!!} 
{!! HTML::script('js/perhatian_khusus.js')!!} 
{!! HTML::script('js/odontogram.js?ver=123')!!} 

<script>
    afiCount();
</script>
@stop
