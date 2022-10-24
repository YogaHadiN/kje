@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Edit Followup Tunggakan

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
{!! Form::model($followup_tunggakan, [
    "role"   => "form",
    "class"  => "m-t",
    "files"  => "true",
    'url' => 'followup_tunggakans/' . $followup_tunggakan->id ,
    'method' => 'put'
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
