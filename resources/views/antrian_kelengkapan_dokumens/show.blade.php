@extends('layout.master')
@section('title') 
  {{ \Auth::user()->tenant->name }} | Proses Kelengkapan Dokumen
@stop
@section('page-title') 
<h2>Proses Kelengkapan Dokumen</h2>
<ol class="breadcrumb">
      <li>
        <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
        <strong>Proses Kelengkapan Dokumen</strong>
      </li>
</ol>
@stop
@section('content') 
    @include('periksas.status')
      <br></br>
      <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
          @include('surveys.komponen_kelengkapan_dokumen')
        </div>
      </div>
      {!! Form::open([
        'url'    => 'antrian_kelengkapan_dokumens/' . $antrian_kelengkapan_dokumen->id,
        'method' => 'post'
      ]) !!}
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <button class="btn btn-success btn-lg btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
          {!! Form::submit('Submit', [
              'class' => 'btn btn-success hide',
              'id'    => 'submit'
          ]) !!}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <a class="btn btn-danger btn-block btn-lg" href="{{ url('home/') }}">Cancel</a>
        </div>
      </div>
      {!! Form::close() !!}
      {!! Form::text('tipe_asuransi', $periksa->asuransi->tipe_asuransi, ['class' => 'form-control hide', 'id' => 'tipe_asuransi']) !!}
@stop
@section('footer') 
	{!! HTML::script('js/show_periksa.js') !!}
	{!! HTML::script('js/antrian_kelengkapan_dokumen_show.js') !!}
@stop
