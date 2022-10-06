@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Sertifikat

@stop
@section('page-title') 
<h2>Buat Sertifikat</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Buat Sertifikat</strong>
    </li>
</ol>

@stop
@section('content') 

    {!! Form::model($sertifikat, [
        "url"    => "sertifikats/" .$sertifikat->id,
        "class"  => "m-t",
        "role"   => "form",
        "files"  => "true",
        "method" => "put"
    ]) !!}
        @include('sertifikats.form')
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
