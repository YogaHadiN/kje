@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Cek List

@stop
@section('page-title') 
<h2>Edit Cek List</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Edit Cek List</strong>
            </li>
</ol>

@stop
@section('content') 
{!! Form::model($cek_list,['url' => 'cek_lists/' . $cek_list->id, 'method' => 'put']) !!}
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
