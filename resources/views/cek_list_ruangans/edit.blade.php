@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Edit Cek List Rurangan {{ $ruangan->nama }}

@stop
@section('page-title') 
    <h2>Edit Cek List Rurangan {{ $ruangan->nama }}</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('laporans')}}">Home</a>
        </li>
        <li class="active">
            <strong>Edit Cek List Rurangan {{ $ruangan->nama }}</strong>
        </li>
    </ol>
@stop
@section('content') 
    {!! Form::model($cek_list_ruangan, ['url' => 'cek_list_ruangans/' . $cek_list_ruangan->id, 'method' => 'put']) !!}
        @include('cek_list_ruangans.form')
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
