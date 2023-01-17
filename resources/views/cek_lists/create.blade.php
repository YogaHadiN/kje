@extends('layout.master')

@section('title') 
Klinik Jati Elok | Create Cek List

@stop
@section('page-title') 
<h2>Create Cek List</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Create Cek List</strong>
            </li>
</ol>

@stop
@section('content') 
{!! Form::open(['url' => 'cek_lists', 'method' => 'post']) !!}
@include('cek_lists.form')
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
