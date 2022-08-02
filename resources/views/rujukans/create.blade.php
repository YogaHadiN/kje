@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Buat Rujukan
@stop
@section('page-title') 
<h2>Buat Rujukan</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('ruangperiksas/' . $periksa->poli_id)}}">Antrian Periksa</a>
      </li>
      <li class="active">
          <strong>Buat Rujukan</strong>
      </li>
</ol>
@stop
@section('content') 
<input type="hidden" id="token" value="{{ Session::token() }}">
{!! Form::open(['url' => 'rujukans/' . $poli, 'method' => 'post'])!!}
	@include('rujukans.form', [
		  'periksa' => $periksa, 
		  'submit' => 'Submit', 
		  'hari' => '1', 
		  'delete' => false, 
		  'jenis_rumah_sakit' => null,
		  'rumah_sakit' => null,
		  'register_hamil_id' => null, 
		  'hamil' => $isHamil,
		  'g' => $g,
		  'p' => $p,
		  'a' => $a,
		  'tanggal_mulai' => date('d-m-Y'), 
		  'hpht' => App\Models\Classes\Yoga::updateDatePrep($hpht)
	  ])
{!! Form::close()!!}
@if($periksa->asuransi_id == '32')
    <div class="alert alert-danger">
        Pasien BPJS <strong>Laki-laki dewasa</strong>  tidak bisa dirujuk ke Sp.PD 
        di RSIA, harus ke RS tapi
        untuk pasien wanita dewasa bisa dirujuk Sp.PD
        di RSIA
    </div>
@endif
@stop
@section('footer') 
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script>
var base = '{{ url("/") }}';
var asuransi_id = '{{$periksa->asuransi_id}}';
</script>
  {!! HTML::script('js/rujukan.js')!!}
<script src="{{ url('js/uk.js') }}" type="text/javascript"></script>
@stop
