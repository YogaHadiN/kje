@extends('layout.master')

@section('title') 
Klinik Jati Elok | Create Setor Tunai

@stop
@section('page-title') 
<h2>Create Setor Tunai</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Create Setor Tunai</strong>
            </li>
</ol>

@stop
@section('content') 
        {!! Form::open([
            "class"  => "m-t",
            "role"   => "form",
            "files"  => "true",
            'url'    => 'setor_tunais',
            'method' => 'post'
        ]) !!}
            @include('setor_tunais.form')
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
