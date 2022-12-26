@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Create Cek List Rurangan {{ $ruangan->nama }}

@stop
@section('page-title') 
    <h2>Create Cek List Rurangan {{ $ruangan->nama }}</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('laporans')}}">Home</a>
        </li>
        <li>
            <a href="{{ url('ruangans')}}">Ruangan</a>
        </li>
        <li class="active">
            <strong>Create Cek List Rurangan {{ $ruangan->nama }}</strong>
        </li>
    </ol>
@stop
@section('content') 
    {!! Form::open(['url' => 'cek_list_ruangans/' . $ruangan->id, 'method' => 'post']) !!}
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
