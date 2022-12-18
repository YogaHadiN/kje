@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Antrian

@stop
@section('page-title') 
<h2>Edit Antrian</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Edit Antrian</strong>
            </li>
</ol>

@stop
@section('content') 
    {!! Form::model($antrian, ['url' => 'antrians/' . $antrian->id , 'method' => 'put']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group @if($errors->has('nama')) has-error @endif">
                  {!! Form::label('nama', null , ['class' => 'control-label']) !!}
                  {!! Form::text('nama' , null, ['class' => 'form-control']) !!}
                  @if($errors->has('nama'))<code>{!! $errors->first('nama') !!}</code>@endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group @if($errors->has('no_telp')) has-error @endif">
                  {!! Form::label('no_telp',null, ['class' => 'control-label']) !!}
                  {!! Form::text('no_telp' , null, ['class' => 'form-control']) !!}
                  @if($errors->has('no_telp'))<code>{!! $errors->first('no_telp') !!}</code>@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group @if($errors->has('tanggal_lahir')) has-error @endif">
                  {!! Form::label('tanggal_lahir',null, ['class' => 'control-label']) !!}
                  {!! Form::text('tanggal_lahir' , $antrian->tanggal_lahir? $antrian->tanggal_lahir->format('d-m-Y'):null, [
                    'class' => 'form-control tanggal'
                  ]) !!}
                  @if($errors->has('tanggal_lahir'))<code>{!! $errors->first('tanggal_lahir') !!}</code>@endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group @if($errors->has('nomor_bpjs')) has-error @endif">
                  {!! Form::label('nomor_bpjs',null, ['class' => 'control-label']) !!}
                  {!! Form::text('nomor_bpjs' , null, ['class' => 'form-control']) !!}
                  @if($errors->has('nomor_bpjs'))<code>{!! $errors->first('nomor_bpjs') !!}</code>@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @if(isset($update))
                    <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
                @else
                    <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
                @endif
                {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a class="btn btn-danger btn-block" href="{{ url('home/') }}">Cancel</a>
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
