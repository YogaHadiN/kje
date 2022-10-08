@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Edit Tarif {{ $asuransi->nama }}

@stop
@section('page-title') 
    <h2>Edit Tarif {{ $asuransi->nama }}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Edit Tarif {{ $asuransi->nama }}</strong>
            </li>
</ol>

@stop
@section('content') 
{!! Form::model($tarif, ['url' => 'asuransis/' . $asuransi->id . '/tarifs/' . $tarif->id, 'method' => 'put']) !!}
<h2> Merubah tindakan <strong> {{ $tarif->jenisTarif->jenis_tarif }} </strong>  untuk asuransi <strong>{{ $asuransi->nama }}</strong> </h2>
    <div class="form-group @if($errors->has('biaya')) has-error @endif">
      {!! Form::label('biaya', 'Biaya', ['class' => 'control-label']) !!}
      {!! Form::text('biaya' , null, ['class' => 'form-control rq uangInput']) !!}
      @if($errors->has('biaya'))<code>{{ $errors->first('biaya') }}</code>@endif
    </div>
    <div class="form-group @if($errors->has('jasa_dokter')) has-error @endif">
      {!! Form::label('jasa_dokter', 'Jasa Dokter', ['class' => 'control-label']) !!}
      {!! Form::text('jasa_dokter' , null, ['class' => 'form-control rq uangInput']) !!}
      @if($errors->has('jasa_dokter'))<code>{{ $errors->first('jasa_dokter') }}</code>@endif
    </div>
    <div class="form-group @if($errors->has('tipe_tindakan_id')) has-error @endif">
      {!! Form::label('tipe_tindakan_id', 'Tipe Tindakan', ['class' => 'control-label']) !!}
      {!! Form::select('tipe_tindakan_id' , \App\Models\TipeTindakan::pluck('tipe_tindakan', 'id'), null, ['class' => 'form-control rq']) !!}
      @if($errors->has('tipe_tindakan_id'))<code>{{ $errors->first('tipe_tindakan_id') }}</code>@endif
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            @if(isset($asuransi))
                <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
            @else
                <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
            @endif
            {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <a class="btn btn-danger btn-block" href="{{ url('asuransis/' . $asuransi->id . '/edit') }}">Cancel</a>
        </div>
    </div>
        
{!! Form::close() !!}
@stop
@section('footer') 
    <script type="text/javascript" charset="utf-8">
        function dummySubmit(control){
            if(validatePass2(control)){
                $('#submit').click();
            }
        }
    </script>
@stop
