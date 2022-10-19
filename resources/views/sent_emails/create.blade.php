@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Email Baru

@stop
@section('page-title') 
<h2>Buat Email Baru</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Buat Email Baru</strong>
    </li>
</ol>

@stop
@section('content') 
    {!! Form::open(['url' => 'sent_emails', 'method' => 'post']) !!}
        @include('sent_emails.form')
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
