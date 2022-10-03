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
    {!! Form::model($document, [
        "url"    => "documents/" .$document->id,
        "class"  => "m-t",
        "role"   => "form",
        "files"  => "true",
        "method" => "put"
    ]) !!}
        @include('documents.form')
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
