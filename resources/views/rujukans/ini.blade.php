@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Lihat Rujukab

@stop
@section('page-title') 
 <h2>List User</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li>
          <a href="{!! url('pasiens')!!}">Pasien</a>
      </li>
      <li>
          <a href="{!! url('pasiens/' . $periksa->pasien_id)!!}">Riwayat Pemeriksaan {{ $periksa->pasien->nama}}</a>
      </li>
      <li class="active">
          <strong>Lihat Rujukan</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-primary">
          <div class="panel-heading">
                <div class="panel-title">
                  <div class="panelLeft">
                    Rujukan
                  </div>
                  <div class="panelRight">
                    <a href="{{ url('pdfs/status/' . $periksa->id)}}" class="btn btn-success" target="_blank">Lihat Status PDF</a>
                  </div>
                </div>
          </div>
          <div class="panel-body">
            <div id="image">
              @if(isset($periksa->rujukan->image))
                <img src="{{ \Storage::disk('s3')->url($periksa->rujukan->image ) }}" alt="">
              @else 
                <img src="{{ \Storage::disk('s3')->url('/img/notfound.jpg') }}" alt="">
              @endif
            </div>

              <br><br>
              <button type="button" class="btn btn-info" onclick="printImage();return false">Print Me</button>
          </div>
    </div>
  </div>
</div>
@stop
@section('footer') 
<script>
  function printImage(){
    var temp = $('#image').html();
    var bodyTemp = $('body').html();

    $('body').html(temp);
    window.print();
    $('body').html(bodyTemp);
  }
</script>

@stop
