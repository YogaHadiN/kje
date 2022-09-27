@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Dokumen

@stop
@section('page-title') 
<h2>Buat Dokumen</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Buat Dokumen</strong>
    </li>
</ol>

@stop
@section('content') 
    {!! Form::open([
        "url"    => "documents",
        "class"  => "m-t",
        "role"   => "form",
        "files"  => "true",
        "method" => "post"
    ]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                </div>
                <div class="panel-body">
                    <div class="form-group @if($errors->has('nama')) has-error @endif">
                      {!! Form::label('nama', 'Nama Dokumen', ['class' => 'control-label']) !!}
                      {!! Form::text('nama' , null, ['class' => 'form-control']) !!}
                      @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
                    </div>
                    <div class="form-group @if($errors->has('tanggal')) has-error @endif">
                      {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
                      {!! Form::text('tanggal' , null, ['class' => 'form-control tanggal']) !!}
                      @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
                    </div>
                    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                        {!! Form::label('url', 'Upload Dokumen Penting') !!}
                        {!! Form::file('url') !!}
                        {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
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
                            <a class="btn btn-danger btn-block" href="{{ url('documents') }}">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
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
