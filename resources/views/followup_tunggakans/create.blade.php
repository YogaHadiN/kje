@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Followup Tunggakan

@stop
@section('page-title') 
<h2>Buat Followup Tunggakan</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Buat Followup Tunggakan</strong>
    </li>
</ol>

@stop
@section('content') 
    {!! Form::open([
        'url'    => 'followup_tunggakans',
        'method' => 'post',
        "role"   => "form",
        "class"  => "m-t",
        "files"  => "true"
    ]) !!}
    @include('followup_tunggakans.form')
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
