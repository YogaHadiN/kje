@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Asuransi

@stop
@section('page-title') 
<h2>SOP Terapi </h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('diagnosas')}}">Diagnosa</a>
      </li>
      <li>
          <a href="{{ url('diagnosas/' .$icd10->id )}}">Edit</a>
      </li>
      <li class="active">
          <strong>SOP terapi</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="row">
  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
      @include('perscribe', ['showSubmit' => true, 'berat_badan_input' => null])
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3>Informasi</h3>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
			<table class="table table-bordered table-stripped">
			  <tbody>
				<tr>
				  <th>Diagnosa ICD</th>
				  <td>{!! $icd10->id!!} - {!! $icd10->diagnosaICD!!}</td>
				</tr>
				<tr>
				  <th>Diagnosa Umum</th>
				  <td>
					<ul>
					  @foreach($icd10->diagnosa as $diagnosa)
					  <li>{!! $diagnosa->diagnosa !!}</li>
					  @endforeach
					</ul>
				  </td>
				</tr>
				<tr>
				  <th>Nama Asuransi</th>
				  <td>{!! $asuransi->nama !!}</td>
				</tr>
				<tr>
				  <th>Berat Badan</th>
				  <td>{!! $berat_badan->berat_badan !!}</td>
				</tr>
			  </tbody>
			</table>
		  </div>
      </div>
    </div>
  </div>
</div>
{!! Form::open(['url' => 'sops'])!!}
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    {!! Form::text('icd10_id', $icd10->id, ['class' => 'form-control hide'])!!}
    {!! Form::text('asuransi_id', $asuransi->id, ['class' => 'form-control hide'])!!}
    {!! Form::text('diagnosa_id', $diagnosa_id, ['class' => 'form-control hide'])!!}
    {!! Form::text('berat_badan_id', $berat_badan->id, ['class' => 'form-control hide'])!!}
    {!! Form::textarea('terapi', null, ['class' => 'form-control hide', 'id' => 'terapis'])!!}
  </div>
</div>

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Terapi Yang Tersedia</h3> {!! $asuransi->nama !!}, {!! $berat_badan->berat_badan!!}
                </div>

            </div>
      </div>
      <div class="panel-body">
        <div class="row" id="terapisContainer">
          
        </div>
      </div>
</div>

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    {!! Form::submit('Submit', ['class' => 'btn btn-success btn-block btn-lg'])!!}
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <button type="button" class="btn btn-danger btn-block btn-lg">Cancel</button>
  </div>
</div>
{!! Form::close()!!}
@stop
@section('footer') 
	<script>
    var base = "{{ url('/') }}";
    console.log(base);
    var terapis = []
  </script>

<script src="{{ url('js/poli.js') }}" type="text/javascript"></script>
<script>
if ($('#terapis').val() == '' || $('#terapis').val() == '[]') {
  var terapis = [];
} else {
  var terapis = $('#terapis').val();
  terapis = $.parseJSON(terapis);
}
  jQuery(document).ready(function($) {
    viewTerapis();
  });
  </script>
  <script>
  function submitResep(){
    if (data != '' || data != [] ) {
      terapis[terapis.length] = data;
      terapiString = JSON.stringify(terapis);
      $('#terapis').val(terapiString);
      viewTerapis();
      clear();
    }
  }

    function clear(){
      $('#ajax5').html('');
      $('#terapi').val('');
      data = [];
      namaObatFocus();
    }

    function viewTerapis(){
      if ($('#terapis').val() == '' || $('#terapis').val() == '[]' ) {
        $('#terapis').val('[]');
        var textKosong = "<h1 class='text-center'>Tidak Ada Terapi Untuk Ditampilkan</h1>"
        $('#terapisContainer').html(textKosong).hide().fadeIn(500);
      } else {

            var jsonTerapis = $('#terapis').val();
            var arrTerapis = $.parseJSON(jsonTerapis);

            var temp = '';
            for (var i = 0; i < arrTerapis.length; i++) {
              var terapi = arrTerapis[i];
              terapi = JSON.stringify(terapi);
              temp += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
              temp += '<div class="panel panel-default">';
              temp += '<div class="panel-body">';
              temp += resepJson(terapi)[0];
              temp += '<br /><button type="button" onclick="delTerapi(this);return false;" class="btn btn-danger btn-block" value="' + i + '">Delete</button>';
              temp += '</div>';
              temp += '</div>';
              temp += '</div>';
            }

            $('#terapisContainer').html(temp).hide().fadeIn(500);
      }
    }

    function delTerapi(control){
      var key = $(control).val();
      terapis.splice(key, 1);
      var terapiString = JSON.stringify(terapis);
      $('#terapis').val(terapiString);
      viewTerapis();


    }
</script>
@stop
