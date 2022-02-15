@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Rujukan

@stop
@section('page-title') 
<h2>Edit Rujukan</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('ruangperiksas/' . $rujukan->periksa->poli)}}">Antrian Periksa</a>
      </li>
      <li class="active">
          <strong>Edit Rujukan</strong>
      </li>
</ol>

@stop
@section('content') 
{!! Form::model($rujukan, ['url' => 'rujukans/' . $rujukan->id . '/' . $poli, 'method' => 'put'])!!}
	@include('rujukans.form', [
    'submit'            => 'Submit', 
    'delete'            => true, 
    'periksa'           => $rujukan->periksa, 
    'register_hamil_id' => $rujukan->register_hamil_id, 
    'hamil'             => $hamil,
    'g'                 => $g,
    'p'                 => $p,
    'a'                 => $a,
    'jenis_rumah_sakit' => $rujukan->rumahSakit->jenis_rumah_sakit,
    'rumah_sakit'       => $rujukan->rumahSakit->nama,
    'tujuan_rujuk'      => $rujukan->tujuanRujuk->tujuan_rujuk,
    'hpht'              => App\Models\Classes\Yoga::updateDatePrep($hpht)
  ])
{!! Form::close()!!}

@stop
@section('footer') 
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script>
var base = '{{ url("/") }}';
var asuransi_id = '{{$rujukan->periksa->asuransi_id}}';
var tujuan_rujuk_tags = {!! $tujuan_rujuks !!};
</script>
  {!! HTML::script('js/rujukan.js')!!}
<script src="{{ url('js/uk.js') }}" type="text/javascript"></script>
@stop
