@extends('layout.master')
@section('title') 
Klinik Jati Elok | Basic
@stop
@section('page-title') 
<h2>Basic</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Basic</strong>
    </li>
</ol>

@stop
@section('content') 
    <h1>Test</h1>
@stop
@section('footer') 
    {!! HTML::script('js/test.js')!!}
@stop
