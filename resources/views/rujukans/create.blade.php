@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Rujukan

@stop
@section('page-title') 
<h2>Buat Rujukan</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('ruangperiksas/' . $periksa->poli)}}">Antrian Periksa</a>
      </li>
      <li class="active">
          <strong>Buat Rujukan</strong>
      </li>
</ol>

@stop
@section('content') 
<input type="hidden" id="token" value="{{ Session::token() }}">
{!! Form::open(['url' => 'rujukans', 'method' => 'post'])!!}
	@include('rujukans.form', [
  'periksa' => $periksa, 


  'submit' => 'Submit', 
  'hari' => '1', 
  'delete' => false, 
  'tujuan_rujuk' => null,
  'jenis_rumah_sakit' => null,
  'rumah_sakit' => null,
  'register_hamil_id' => null, 
  'hamil' => $isHamil,
  'g' => $g,
  'p' => $p,
  'a' => $a,
  'tanggal_mulai' => date('d-m-Y'), 
  'hpht' => App\Classes\Yoga::updateDatePrep($hpht)



  ])
{!! Form::close()!!}
@stop
@section('footer') 
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>

	<script>
    var base = '{{ url("/") }}';
    var asuransi_id = '{{$periksa->asuransi_id}}';
    var tujuan_rujuk_tags = '{!! $tujuan_rujuks !!}';
    tujuan_rujuk_tags = $.parseJSON(tujuan_rujuk_tags);
  </script>
  {!! HTML::script('js/rujukan.js')!!}
<script src="{{ url('js/uk.js') }}" type="text/javascript"></script>

@stop