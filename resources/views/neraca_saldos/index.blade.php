@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Neraca Saldo

@stop
@section('page-title') 
 <h2>List Neraca Saldo</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List Neraca Saldo</strong>
      </li>
</ol>
@stop
@section('content') 
{!! Form::open(['url' => 'neraca_saldos/show', 'method' => 'get']) !!}
<div class="panel panel-default">
  <div class="panel-body">
    <h1>Pilih Neraca Saldo</h1>
    <hr>
    <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		  
		  <div class="form-group @if($errors->has('bulan'))has-error @endif">
		    {!! Form::label('bulan', 'Bulan', ['class' => 'control-label']) !!}
			{!! Form::select('bulan', App\Models\Classes\Yoga::bulanList(), date('m'), ['class' => 'form-control rq']) !!}
		    @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
		  </div>
		  
		  <div class="form-group @if($errors->has('tahun'))has-error @endif">
		    {!! Form::label('tahun', 'Tahun', ['class' => 'control-label']) !!}
            {!! Form::text('tahun', date('Y'), ['class' => 'form-control rq']) !!}
		    @if($errors->has('tahun'))<code>{{ $errors->first('tahun') }}</code>@endif
		  </div>
        <div class="form-group">
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit(); return false;">Submit</button>
              <button class="btn btn-success btn-block btn-lg hide" id="submit" type="submit">Submit</button>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <a href="{{ url('neraca_saldos') }}" class="btn btn-danger btn-block btn-lg">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}
@stop
@section('footer') 
<script>
  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>

@stop
